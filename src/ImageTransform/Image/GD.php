<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Image;

use ImageTransform\Image;
use ImageTransform\FileAccessAdapter;

/**
 * Concrete Image class using GD
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class GD extends Image implements FileAccessAdapter
{
  /**
   * Create an image resource
   *
   * @see ImageTransform\FileAccessAdapter
   *
   * @param integer              $width  Width of the image to be created
   * @param integer              $height Height of the image to be created
   */
  public function create($width, $height)
  {
    $resource = imagecreatetruecolor($width, $height);

    $this->set('image.resource',  $resource);
    $this->set('image.width',     $width);
    $this->set('image.height',    $height);
  }

  /**
   * Open a resource for an Image
   *
   * @see ImageTransform\FileAccessAdapter
   *
   * @param string               $filepath Location of the file to open
   */
  public function open($filepath)
  {
    if (!is_readable($filepath))
    {
      throw new \InvalidArgumentException('File "'.$filepath.'" not readable!');
    }

    $info = getimagesize($filepath);

    switch ($info['mime'])
    {
      case 'image/gif':
        $resource = imagecreatefromgif($filepath);
        break;
      case 'image/jpg':
      case 'image/jpeg':
        $resource = imagecreatefromjpeg($filepath);
        break;
      case 'image/png':
        $resource = imagecreatefrompng($filepath);
        break;
      default:
        throw new \UnexpectedValueException('Images of type "'.$info['mime'].'" are not supported!');
    }

    $this->set('image.filepath',  $filepath);
    $this->set('image.resource',  $resource);
    $this->set('image.width',     $info[0]);
    $this->set('image.height',    $info[1]);
    $this->set('image.mime_type', $info['mime']);
  }

  /**
   * Flush an Image resource to stdout
   *
   * @see ImageTransform\FileAccessAdapter
   *
   * @param string               $mimeType Mime type of the target file
   */
  public function flush($mimeType = false)
  {
    $this->out(null, $mimeType);
  }

  /**
   * Save an Image resource under its current location
   *
   * @see ImageTransform\FileAccessAdapter
   */
  public function save()
  {
    if (false === ($filepath = $this->get('image.filepath')))
    {
      throw new \InvalidArgumentException('No filepath set on image! Use saveAs() instead.');
    }

    $this->saveAs($filepath);
  }

  /**
   * Save an Image resource under a given filepath
   *
   * @see ImageTransform\FileAccessAdapter
   *
   * @param string               $filepath Locastion where to save the resource
   * @param string               $mimeType Mime type of the target file
   */
  public function saveAs($filepath, $mimeType = false)
  {
    if ((file_exists($filepath) && !is_writable($filepath)) ||
        (!file_exists($filepath) && !is_writable(dirname($filepath))))
    {
      throw new \InvalidArgumentException('File "'.$filepath.'" not writeable!');
    }

    $this->out($filepath, $mimeType);
  }

  /**
   * Save an Image resource under a given filepath
   *
   * @see ImageTransform\FileAccessAdapter
   *
   * @param string               $filepath Locastion where to save the resource
   * @param string               $mimeType Mime type of the target file
   */
  protected function out($filepath, $mimeType = false)
  {
    if (!($resource = $this->get('image.resource')))
    {
      throw new \UnexpectedValueException('Could not read resource!');
    }

    if (false === $mimeType)
    {
      $mimeType = $this->get('image.mime_type');
    }

    switch ($mimeType)
    {
      case 'image/gif':
        imagegif($resource, $filepath);
        break;
      case 'image/jpg':
      case 'image/jpeg':
        imagejpeg($resource, $filepath);
        break;
      case 'image/png':
        imagepng($resource, $filepath);
        break;
      default:
        throw new \UnexpectedValueException('Images of type "'.$mimeType.'" are not supported!');
    }
  }
}

