<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Transformation\Resizer;

use ImageTransform\Transformation\Resizer;

/**
 * Concrete GD implementation of the resize transformation
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class GD extends Resizer
{
  protected function doResize($originalImage, $originalWidth, $originalHeight, $targetWidth, $targetHeight)
  {
    $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);

    imagecopyresampled($targetImage, $originalImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $originalWidth, $originalHeight);

    return $targetImage;
  }
}
