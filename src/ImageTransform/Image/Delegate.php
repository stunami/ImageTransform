<?php

namespace ImageTransform\Image;

abstract class Delegate
{
  protected $image;

  public function __construct(\ImageTransform\Image $image)
  {
    $this->image = $image;
  }
}
