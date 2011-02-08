<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Transformation;

use ImageTransform\Image;

/**
 * Abstract implementation of the resize transformation. Includes the calculation of the target size.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
abstract class Resizer
{
  const PROPORTIONAL = 1;
  const NO_INFLATE   = 2;
  const NO_DEFLATE   = 4;
  const MINIMUM      = 8;

  public function resize(\ImageTransform\Image $image, $targetWidth, $targetHeight, $flags = 0)
  {
    $originalImage = $image->get('image.resource');
    $originalWidth = $image->get('image.width');
    $originalHeight = $image->get('image.height');

    list($finalWidth, $finalHeight) = $this->computeFinalDimension($originalWidth, $originalHeight, $targetWidth, $targetHeight, $flags);

    if (($finalImage = $this->doResize($originalImage, $originalWidth, $originalHeight, $finalWidth, $finalHeight)))
    {
      $image->set('image.resource', $finalImage);
      $image->set('image.width', $finalWidth);
      $image->set('image.height', $finalHeight);
    }

    return $image;
  }

  protected function computeFinalDimension($originalWidth, $originalHeight, $targetWidth, $targetHeight, $flags)
  {
    if (!($flags & self::PROPORTIONAL))
    {
      if ($flags & self::NO_INFLATE && $flags & self::NO_DEFLATE)
      {
        $finalWidth = $originalWidth;
        $finalHeight = $originalHeight;
      }
      else if ($flags & self::NO_INFLATE)
      {
        $finalWidth = min($originalWidth, $targetWidth);
        $finalHeight = min($originalHeight, $targetHeight);
      }
      else if ($flags & self::NO_DEFLATE)
      {
        $finalWidth = max($originalWidth, $targetWidth);
        $finalHeight = max($originalHeight, $targetHeight);
      }
      else
      {
        $finalWidth = $targetWidth;
        $finalHeight = $targetHeight;
      }
    }
    else
    {
      if ((($flags & self::NO_INFLATE && ($originalWidth < $targetWidth || $originalHeight < $targetHeight)) ||
           ($flags & self::NO_DEFLATE && ($originalWidth > $targetWidth || $originalHeight > $targetHeight))) &&
         !((!($flags & self::NO_INFLATE) && $flags & self::MINIMUM && ($originalWidth < $targetWidth xor $originalHeight < $targetHeight)) ||
           (!($flags & self::NO_DEFLATE) && !($flags & self::MINIMUM) && ($originalWidth > $targetWidth xor $originalHeight > $targetHeight))))
      {
        $finalWidth = $originalWidth;
        $finalHeight = $originalHeight;
      }
      else
      {
        $scaleWidthFactor = $targetWidth / $originalWidth;
        $scaleHeightFactor = $targetHeight / $originalHeight;

        if ($scaleWidthFactor == $scaleHeightFactor) // same ratio
        {
          $finalWidth = $targetWidth;
          $finalHeight = $targetHeight;
        }
        else if ($scaleWidthFactor < $scaleHeightFactor === (boolean) ($flags & self::MINIMUM))
        {
          $finalHeight = $targetHeight;
          $finalWidth = round(($originalWidth * $finalHeight) / $originalHeight);
        }
        else
        {
          $finalWidth = $targetWidth;
          $finalHeight = round(($originalHeight * $finalWidth) / $originalWidth);
        }
      }
    }
  
    return array($finalWidth, $finalHeight);
  }

  abstract protected function doResize($originalImage, $originalWidth, $originalHeight, $targetWidth, $targetHeight);
}
