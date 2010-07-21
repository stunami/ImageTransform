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
 * Colorizes an image
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Transform_Abstract_Colorize  extends ImageTransform_Transform_Abstract
{
  /**
   * Red Tint.
  */
  private $red_tint = 0;

  /**
   * Green Tint.
  */
  private $green_tint = 0;

  /**
   * Blue Tint.
  */
  private $blue_tint = 0;

  /**
   * Alpha.
  */
  private $alpha = 0;

  /**
   * Construct an Colorize object.
   *
   * @param integer
   * @param integer
   * @param integer
   * @param integer
   */
  public function __construct($red, $green, $blue, $alpha=0)
  {
    $this->setRed($red);
    $this->setGreen($green);
    $this->setBlue($blue);
    $this->setAlpha($alpha);
  }

  /**
   * Sets the red
   *
   * @param integer
   * @return boolean
   */
  private function setRed($red)
  {
    if (is_numeric($red))
    {
      $this->red_tint = (int)$red;

      return true;
    }

    return false;
  }

  /**
   * Gets the red
   *
   * @return integer
   */
  protected function getRed()
  {
    return $this->red_tint;
  }

  /**
   * Sets the green
   *
   * @param integer
   * @return boolean
   */
  private function setGreen($green)
  {
    if (is_numeric($green))
    {
      $this->green_tint = (int)$green;

      return true;
    }

    return false;
  }

  /**
   * Gets the green
   *
   * @return integer
   */
  protected function getGreen()
  {
    return $this->green_tint;
  }

  /**
   * Sets the blue
   *
   * @param integer
   * @return boolean
   */
  private function setBlue($blue)
  {
    if (is_numeric($blue))
    {
      $this->blue_tint = (int)$blue;

      return true;
    }

    return false;
  }

  /**
   * Gets the blue
   *
   * @return integer
   */
  protected function getBlue()
  {
    return $this->blue_tint;
  }

  /**
   * Sets the alpha
   *
   * @param integer
   * @return boolean
   */
  private function setAlpha($alpha)
  {
    if (is_numeric($alpha))
    {
      $this->alpha = (int)$alpha;

      return true;
    }

    return false;
  }

  /**
   * Gets the alpha
   *
   * @return integer
   */
  protected function getAlpha()
  {
    return $this->alpha;
  }
}
