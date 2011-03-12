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
use \ImageTransform\Transformation\ImageMagickInterface;

/**
 * Concrete ImageMagick implementation of the resize transformation
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class ImageMagick extends Resizer implements ImageMagickInterface
{
  protected function doResize($originalImage, $originalWidth, $originalHeight, $targetWidth, $targetHeight)
  {
    $originalImage->resizeImage($targetWidth, $targetHeight, \Imagick::FILTER_LANCZOS, false);

    return $originalImage;
  }
}
