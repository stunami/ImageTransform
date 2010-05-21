<?php
/*
 * This file is part of the sfImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * ImageTransformEdgeDetect class.
 *
 * Uses edge detection to highlight the edges in the GD image.
 *
 * @package ImageTransform
 * @subpackage base
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @version SVN: $Id$
 */
class ImageTransformEdgeDetectGD extends BaseImageTransformEdgeDetect
{
  /**
   * Apply the transform to the sfImage object.
   *
   * @param sfImage
   * @return sfImage
   */
  protected function transform(sfImage $image)
  {
    return $image;
  }
}
