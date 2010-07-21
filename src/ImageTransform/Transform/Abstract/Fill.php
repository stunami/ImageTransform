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
 * Fills the set area with a color or tile image.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Transform_Abstract_Fill extends ImageTransform_Transform_Abstract
{
  /**
   * x-coordinate.
   * @var integer
  */
  private $x = 0;

  /**
   * y-coordinate
   * @var integer
  */
  private $y = 0;

  /**
   * Fill.
  */
  private $fill = null;

  /**
   * Construct an Duotone object.
   *
   * @param integer
   * @param integer
   * @param string/object hex color or ImageTransform_Source object
   */
  public function __construct($x=0, $y=0, $fill='#000000')
  {
    $this->setX($x);
    $this->setY($y);
    $this->setFill($fill);
  }

  /**
   * Sets the X coordinate
   *
   * @param integer
   * @return boolean
   */
  private function setX($x)
  {
    if (is_numeric($x))
    {
      $this->x = (int)$x;

      return true;
    }

    return false;
  }

  /**
   * Gets the X coordinate
   *
   * @return integer
   */
  protected function getX()
  {
    return $this->x;
  }

  /**
   * Sets the Y coordinate
   *
   * @param integer
   * @return boolean
   */
  private function setY($y)
  {
    if (is_numeric($y))
    {
      $this->y = (int)$y;

      return true;
    }

    return false;
  }

  /**
   * Gets the Y coordinate
   *
   * @return integer
   */
  protected function getY()
  {
    return $this->y;
  }

  /**
   * Sets the fill
   *
   * @param mixed
   * @return boolean
   */
  protected function setFill($fill)
  {
    if (preg_match('/#[\d\w]{6}/',$fill) || ($fill instanceof ImageTransform_Source))
    {
      $this->fill = $fill;

      return true;
    }

    return false;
  }

  /**
   * Gets the fill
   *
   * @return mixed
   */
  protected function getFill()
  {
    return $this->fill;
  }
}
