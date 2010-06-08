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
 * Rotates an image.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Transform_Abstract_Rotate extends ImageTransform_Transform_Abstract
{
  /**
   * Angle to rotate
   *
   * @param integer
   */
  protected $angle;

  /**
   * Background color.
   *
   * @param integer
   */
  protected $background = '';
  /**
   * Construct.
   *
   * @param integer
   * @param string
   */
  public function __construct($angle, $background='')
  {
    $this->setAngle($angle);
    $this->setBackgroundColor($background);
  }

  /**
   * set the angle to rotate the image by.
   *
   * @param integer
   */
  public function setAngle($angle)
  {
    $this->angle = $angle;
  }

  /**
   * Gets the angle to rotate the image by.
   *
   * @return integer
   */
  public function getAngle()
  {
    return $this->angle;
  }

  /**
   * set the background color for the image.
   *
   * @param integer
   */
  public function setBackgroundColor($color)
  {
    $this->background = $color;
  }

  /**
   * Gets the angle to rotate the image by.
   *
   * @return integer
   */
  public function getBackgroundColor()
  {
    return $this->background;
  }

}
