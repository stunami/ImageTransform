<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Image;

use ImageTransform\Image\Delegate;

/**
 * Loader class.
 *
 * Abstract Delegate class providing creating and loading methods.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
abstract class Loader extends Delegate
{
  public function create($width, $height)
  {
    $this->createImage($width, $height);
    return $this->image;
  }

  public function from($filepath)
  {
    $this->image->set('image.filepath', $filepath);
    $this->loadImage($filepath);
    return $this->image;
  }

  abstract protected function loadImage($filepath);
  abstract protected function createImage($width, $height);

  protected function setResource($resource)
  {
    $this->image->set('image.resource', $resource);
  }

  protected function setMimeType($mimeType)
  {
    $this->image->set('image.mime_type', $mimeType);
  }

  protected function setDimensions($width, $height)
  {
    $this->image->set('image.width',  $width);
    $this->image->set('image.height', $height);
  }
}
