<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Image\Transformation\Resize;

use ImageTransform\Image\Transformation\Resize;

/**
 * Concrete GD implementation of the resize transformation
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class GD extends Resize
{
  protected function doResize($originalImage, $originalWidth, $originalHeight, $targetWidth, $targetHeight)
  {
    $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);

    imagecopyresampled($targetImage, $originalImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $originalWidth, $originalHeight);

    return $targetImage;
  }
}
