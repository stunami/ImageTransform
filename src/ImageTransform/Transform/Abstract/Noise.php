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
 * Base class for drawing an arc
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Tranform_Abstract_Noise extends ImageTransform_Transform_Abstract
{
  /**
   * Noise density.
  */
  protected $density = 20;

  /**
   * Construct an sfImageDuotone object.
   *
   * @param integer
   */
  public function __construct($density=20)
  {
    $this->setDensity($density);
  }

  /**
   * Sets the density
   *
   * @param integer
   * @return boolean
   */
  public function setDensity($density)
  {
    if (is_numeric($density))
    {
      $this->density = (int)$density;

      return true;
    }

    return false;
  }

  /**
   * Gets the density
   *
   * @return integer
   */
  public function getdensity()
  {
    return $this->density;
  }
}
