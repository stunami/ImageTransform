<?php

namespace ImageTransform\Image;

use ImageTransform\Image\Delegate;

class Dumper extends Delegate
{
  public function out()
  {
    echo 'barfoo'; // $this->image;

    return $this->image;
  }

  public function save()
  {
    if (!($filepath = $this->image->get('image.filepath')))
    {
      throw new \InvalidArgumentException('No filepath set on image! Use saveAs() instead.');
    }

    return $this->saveAs($filepath);
  }

  public function saveAs($filepath)
  {
    file_put_contents($filepath, 'barfoo');

    return $this->image;
  }
}
