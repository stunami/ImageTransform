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
 * Scales an image by the set amount.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Gd
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_Gd_Scale extends ImageTransform_Transform_Abstract_Scale
{
  /**
   * Apply the transform to the object.
   *
   * @return ImageTransform_Source
   */
  protected function transform()
  {
    $resource = $this->getResource();

    $x = imagesx($resource);
    $y = imagesy($resource);

    $this->getImage()->resize(round($x * $this->getScale()),round($y * $this->getScale()));

    return $this->getImage();
  }
}
