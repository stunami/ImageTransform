<?php

namespace ImageTransform\Image;

use ImageTransform\Image\Delegate;

class Loader extends Delegate
{
  public function create($width, $height)
  {
    $this->image->set('image.width', $width);
    $this->image->set('image.height', $height);
    return $this->image;
  }

  public function from($filepath)
  {
    $this->image->set('image.filepath', $filepath);
    return $this->image;
  }
}
