<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Image\Transformation;

use ImageTransform\Image\Delegate;

/**
 * Abstract implementation of the resize transformation. Includes the calculation of the target size.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
abstract class Resize extends Delegate
{
  const PROPORTIONAL = 1;
  const NO_INFLATE   = 2;
  const NO_DEFLATE   = 4;
  const MINIMUM      = 8;

  public function resize($targetWidth, $targetHeight, $flags = 0)
  {
    $originalImage = $this->image->get('image.resource');
    $originalWidth = $this->image->get('image.width');
    $originalHeight = $this->image->get('image.height');

    list($finalWidth, $finalHeight) = $this->computeFinalDimension($originalWidth, $originalHeight, $targetWidth, $targetHeight, $flags);

    if (($finalImage = $this->doResize($originalImage, $originalWidth, $originalHeight, $finalWidth, $finalHeight)))
    {
      $this->image->set('image.resource', $finalImage);
      $this->image->set('image.width', $finalWidth);
      $this->image->set('image.height', $finalHeight);
    }

    return $this->image;
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
