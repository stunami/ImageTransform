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
 * Smooths an image.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Tranform_Abstract_Smooth extends ImageTransform_Transform_Abstract
{
  /**
   * Smoothness level to be applied.
  */
  protected $smoothness = 0;

  /**
   * Construct an sfImageSmooth object.
   *
   * @param integer
   */
  public function __construct($smoothness=0)
  {
    $this->setSmoothness($smoothness);
  }

  /**
   * Sets the smoothness
   *
   * @param integer
   * @return boolean
   */
  public function setSmoothness($smoothness)
  {
    if (is_numeric($smoothness))
    {
      $this->smoothness = (int)$smoothness;

      return true;
    }

    return false;
  }

  /**
   * Gets the smoothness
   *
   * @return integer
   */
  public function getSmoothness()
  {
    return $this->smoothness;
  }
}
