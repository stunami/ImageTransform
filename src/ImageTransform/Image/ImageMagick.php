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
 * Concrete Image class using ImageMagick
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class ImageMagick extends Image implements FileAccessAdapter
{
  /**
   * Initializes image-api specific code
   */
  protected function initialize()
  {
    if (!extension_loaded('imagick'))
    {
      throw new \RuntimeException('The image processing library ImageMagick is not enabled. See PHP Manual for installation instructions.');
    }
  }

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
    $resource = new \Imagick();
    $resource->newImage($width, $height, new \ImagickPixel('none'));

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

    try
    {
      $resource = new \Imagick($filepath);
    }
    catch(\ImagickException $e)
    {
      throw new \UnexpectedValueException($e->getMessage());
    }

    $this->set('image.filepath',  $filepath);
    $this->set('image.resource',  $resource);
    $this->set('image.width',     $resource->getImageWidth());
    $this->set('image.height',    $resource->getImageHeight());
    $this->set('image.mime_type', $resource->getImageMimeType());
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
    $resource = $this->checkResource();
    $this->syncMimeType($resource, $mimeType);

    echo $resource;
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

    return $this->saveAs($filepath);
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
    $resource = $this->checkResource();
    $this->syncMimeType($resource, $mimeType);

    if ((file_exists($filepath) && !is_writable($filepath)) ||
        (!file_exists($filepath) && !is_writable(dirname($filepath))))
    {
      throw new \InvalidArgumentException('File "'.$filepath.'" not writeable!');
    }

    return $resource->writeImage($filepath);
  }

  /**
   * Returns the currentlz set resource
   *
   * @return \Imagick
   */
  protected function checkResource()
  {
    if (!(($resource = $this->get('image.resource')) && $resource instanceof \Imagick))
    {
      throw new \UnexpectedValueException('Could not read resource!');
    }

    return $resource;
  }

  /**
   * Updates mime type on resource
   *
   * @param string               $filepath Locastion where to save the resource
   * @param string               $mimeType Mime type of the target file
   */
  protected function syncMimeType($resource, $mimeType = false)
  {
    if (false === $mimeType)
    {
      $mimeType = $this->get('image.mime_type');
    }

    if (empty($mimeType))
    {
      throw new \UnexpectedValueException('Mime type not set!');
    }

    list(,$format) = explode('/', $mimeType);
    $resource->setImageFormat($format);
  }
}
