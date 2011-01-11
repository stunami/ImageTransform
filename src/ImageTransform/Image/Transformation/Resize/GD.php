<?php

namespace ImageTransform\Image\Transformation\Resize;

use ImageTransform\Image\Transformation\Resize;

class GD extends Resize
{
  protected function doResize($originalImage, $originalWidth, $originalHeight, $targetWidth, $targetHeight)
  {
    $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);

    imagecopyresampled($targetImage, $originalImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $originalWidth, $originalHeight);

    return $targetImage;
  }
}
