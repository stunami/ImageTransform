<?php
/*
 * This file is part of the sfImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * BaseImageTransformRotate class.
 *
 * Rotates an image.
 *
 * Rotates image by a set angle.
 *
 * @package sfImageTransform
 * @subpackage transforms
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @version SVN: $Id$
 */
class BaseImageTransformRotate extends BaseImageTransform
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
   * Construct an sfImageCrop object.
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

  /**
   * Apply the transform to the sfImage object.
   *
   * @param sfImage
   * @return sfImage
   */
  protected function transform(sfImage $image)
  {
    return $image;
  }
}
