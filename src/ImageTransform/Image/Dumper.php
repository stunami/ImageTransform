<?php

namespace ImageTransform\Image;

use ImageTransform\Image\Delegate;

abstract class Dumper extends Delegate
{
  public function out($mimeType = false)
  {
    echo $this->dump($mimeType);

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
    file_put_contents($filepath, $this->dump());

    return $this->image;
  }

  abstract protected function dump($mimeType = false);
}
