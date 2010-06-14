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
 * @subpackage Gd
 * @version    $Id:$
 */

/**
 * Fills the set area with a color or tile image.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Gd
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_Gd_Fill extends ImageTransform_Transform_Abstract_Fill
{
  /**
   * Apply the transform to the ImageTransform_Source object.
   *
   * @return ImageTransform_Source
   */
  protected function transform()
  {
    $resource = $this->getResource();

    if (is_object($this->getFill()))
    {
      imagesettile($resource, $this->getFill()->getAdapter()->getHolder());
      imagefill($resource, $this->getX(), $this->getY(), IMG_COLOR_TILED);
    }
    else
    {
      $fill = $this->getImage()->getAdapter()->getColorByHex($resource, $this->getFill());
      imagefill($resource, $this->getX(), $this->getY(), $fill);
    }

    return $this->getImage();
  }
}
