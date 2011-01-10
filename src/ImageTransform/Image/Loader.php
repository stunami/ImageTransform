<?php

namespace ImageTransform\Image;

use ImageTransform\Image\Delegate;

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
