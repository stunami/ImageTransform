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
 * @version    $Id:$
 */

/**
 * Gives the image a disintegrated look
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Transform_Abstract_Scatter extends ImageTransform_Transform_Abstract
{
  /**
   * Scatter factor.
  */
  private $scatter_factor = 4;

  /**
   * Construct an Duotone object.
   *
   * @param integer
   */
  public function __construct($scatter=4)
  {
    $this->setScatterFactor($scatter);
  }

  /**
   * Set the scatter factor.
   *
   * @param integer
   */
  private function setScatterFactor($width)
  {
    $this->width = (int)$width;
  }

  /**
   * Gets the scatter factor
   *
   * @return integer
   */
  protected function getScatterFactor()
  {
    return $this->width;
  }
}
