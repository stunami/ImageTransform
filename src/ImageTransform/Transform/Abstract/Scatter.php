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
abstract class ImageTransform_Tranform_Abstract_Scatter extends ImageTransform_Transform_Abstract
{
  /**
   * Scatter factor.
  */
  protected $scatter_factor = 4;

  /**
   * Construct an sfImageDuotone object.
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
  public function setScatterFactor($width)
  {
    $this->width = (int)$width;
  }

  /**
   * Gets the scatter factor
   *
   * @return integer
   */
  public function getScatterFactor()
  {
    return $this->width;
  }
}
