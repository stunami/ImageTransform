<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\FileAccessAdapter;

/**
 * File access for image resources using GD
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class GD implements FileAccessAdapter
{
  /**
   * Create an image resource
   *
   * @see ImageTransform\FileAccessAdapter
   *
   * @param ImageTransform\Image $image  Instance to create a resource for
   * @param integer              $width  Width of the image to be created
   * @param integer              $height Height of the image to be created
   */
  public function create(ImageTransform\Image $image, $width, $height)
  {
    $resource = imagecreatetruecolor($width, $height);

    $image->set('image.resource',  $resource);
    $image->set('image.width',     $width);
    $image->set('image.height',    $height);
  }

  /**
   * Open a resource for an Image
   *
   * @see ImageTransform\FileAccessAdapter
   *
   * @param ImageTransform\Image $image    Instance to create a resource for
   * @param string               $filepath Location of the file to open
   */
  public function open(ImageTransform\Image $image, $filepath)
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

    $image->set('image.filepath',  $filepath);
    $image->set('image.resource',  $resource);
    $image->set('image.width',     $info[0]);
    $image->set('image.height',    $info[1]);
    $image->set('image.mime_type', $info['mime']);
  }

  /**
   * Flush an Image resource to stdout
   *
   * @see ImageTransform\FileAccessAdapter
   *
   * @param ImageTransform\Image $image    Instance to create a resource for
   * @param string               $mimeType Mime type of the target file
   */
  public function flush(ImageTransform\Image $image, $mimeType = false)
  {
    $this->saveAs($image, null, $mimeType);
  }

  /**
   * Save an Image resource under its current location
   *
   * @see ImageTransform\FileAccessAdapter
   *
   * @param ImageTransform\Image $image  Instance to create a resource for
   */
  public function save(ImageTransform\Image $image)
  {
    if (false === ($filepath = $image->get('image.filepath')))
    {
      throw new \InvalidArgumentException('No filepath set on image! Use saveAs() instead.');
    }

    $this->saveAs($image, $filepath);
  }

  /**
   * Save an Image resource under a given filepath
   *
   * @see ImageTransform\FileAccessAdapter
   *
   * @param ImageTransform\Image $image    Instance to create a resource for
   * @param string               $filepath Locastion where to save the resource
   * @param string               $mimeType Mime type of the target file
   */
  public function saveAs(ImageTransform\Image $image, $filepath, $mimeType = false)
  {
    if (!($resource = $this->image->get('image.resource')))
    {
      throw new \UnexpectedValueException('Could not read resource!');
    }

    if (!is_writable($filepath))
    {
      throw new \InvalidArgumentException('File "'.$filepath.'" not writeable!');
    }

    if (false === $mimeType)
    {
      $mimeType = $image->get('image.mime_type');
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

