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
 * Base class for drawing a basic border around the image
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Transform_Abstract_Border extends ImageTransform_Transform_Abstract
{
  /**
   * thickness of the border
   */
  private $thickness = 1;

  /**
   * Hex color.
   *
   * @var string
  */
  private $color = '';

  /**
   * Construct an Border Transform object.
   *
   * @param integer
   * @param string
   */
  public function __construct($thickness, $color=null)
  {
    $this->setThickness($thickness);
    $this->setColor($color);
  }

  /**
   * Sets the thickness
   *
   * @param integer
   * @return boolean
   */
  private function setThickness($thickness)
  {
    if (is_numeric($thickness))
    {
      $this->thickness = (int)$thickness;

      return true;
    }

    return false;
  }

  /**
   * Gets the thickness
   *
   * @return integer
   */
  protected function getThickness()
  {
    return $this->thickness;
  }

  /**
   * Sets the border color in hex
   *
   * @return boolean
   */
  private function setColor($color)
  {
    if (preg_match('/#[\d\w]{6}/',$color))
    {
      $this->color = $color;

      return true;
    }

    return false;
  }

  /**
   * Gets the color
   *
   * @return integer
   */
  protected function getColor()
  {
    return $this->color;
  }
}
