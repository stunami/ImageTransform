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
abstract class ImageTransform_Transform_Abstract_Smooth extends ImageTransform_Transform_Abstract
{
  /**
   * Smoothness level to be applied.
  */
  private $smoothness = 0;

  /**
   * Construct an Smooth object.
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
  private function setSmoothness($smoothness)
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
  protected function getSmoothness()
  {
    return $this->smoothness;
  }
}
