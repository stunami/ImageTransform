<?php
/**
 * This file is part of the ImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Generic
 * @version    $Id:$
 */

/**
 * gd implementation. draws a basic border around the image
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Generic
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Miloslav Kmet <miloslav.kmet@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_Generic_Border extends ImageTransform_Transform_Abstract_Border
{
  /**
   * Apply the transformation to the image and returns the image thumbnail
   * @param ImageTransform_Source $image
   * @return ImageTransform_Source
   */
  protected function transform(ImageTransform_Source $image)
  {
    // Work out where we need to draw to
    $offset = $this->getThickness() / 2;
    $mod = $this->getThickness() % 2;

    $x2 = $image->getWidth() - $offset - ($mod === 0 ? 1 : 0);
    $y2 = $image->getHeight() - $offset - ($mod === 0 ? 1 : 0);

    $image->rectangle($offset, $offset, $x2, $y2, $this->getThickness(), $this->getColor());

    return $image;
  }
}
