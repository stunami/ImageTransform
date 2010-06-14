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
abstract class ImageTransform_Transform_Abstract_Arc extends ImageTransform_Transform_Abstract
{
  /**
   * X-coordinate of the center.
   * @var integer
  */
  private $x = 0;

  /**
   * Y-coordinate of the center.
   * @var integer
  */
  private $y = 0;

  /**
   * The arc width
   * @var integer
  */
  private $width = 0;

  /**
   * The arc height
   * @var integer
  */
  private $height = 0;

  /**
   * Line thickness
   * @var integer
  */
  private $thickness = 0;

  /**
   * The arc start angle, in degrees.
   * @var integer
  */
  private $start_angle = 0;

  /**
   * The arc end angle, in degrees.
   * @var integer
  */
  private $end_angle = 90;

  /**
   * Line color.
   * @var string hex
  */
  private $color = '#000000';

  /**
   * Fill.
   * @var string/ImageTransform_Source hex color or ImageTransform_Source
  */
  private $fill = null;

  /**
   * Line style.
   * @var integer
  */
  private $style = null;

  /**
   * Construct an Arc Transform object.
   *
   * @param integer $x x coordinate
   * @param integer $y y coordinate
   * @param integer $width width of arc
   * @param integer $height height of arc
   * @param integer $start_angle angle in degrees
   * @param integer $end_angle angle in degrees
   * @param integer $thickness line thickness
   * @param string  $color hex color of line
   * @param string/object $fill string color or fill object
   * @param integer $style fill style, only applicable if using a fill object
   */
  public function __construct($x, $y, $width, $height, $start_angle, $end_angle, $thickness = 1, $color = '#000000', $fill=null, $style = null )
  {
    $this->setX($x);
    $this->setY($y);
    $this->setWidth($width);
    $this->setHeight($height);
    $this->setStartAngle($start_angle);
    $this->setEndAngle($end_angle);
    $this->setThickness($thickness);
    $this->setColor($color);
    $this->setFill($fill);
    $this->setStyle($style);
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
   * Sets the width
   *
   * @param integer
   * @return boolean
   */
  private function setWidth($width)
  {
    if (is_numeric($width))
    {
      $this->width = (int)$width;

      return true;
    }

    return false;
  }

  /**
   * Gets the Width
   *
   * @return integer
   */
  protected function getWidth()
  {
    return $this->width;
  }

  /**
   * Sets the height
   *
   * @param integer
   * @return boolean
   */
  private function setHeight($height)
  {
    if (is_numeric($height))
    {
      $this->height = (int)$height;

      return true;
    }

    return false;
  }

  /**
   * Gets the height
   *
   * @return integer
   */
  protected function getHeight()
  {
    return $this->height;
  }

  /**
   * Sets the start angel
   *
   * @param integer
   * @return boolean
   */
  private function setStartAngle($start_angle)
  {
    if (is_numeric($start_angle))
    {
      $this->start_angle = (int)$start_angle;

      return true;
    }

    return false;
  }

  /**
   * Gets the start angel
   *
   * @return integer
   */
  protected function getStartAngle()
  {
    return $this->start_angle;
  }

  /**
   * Sets the end angel
   *
   * @param integer
   * @return boolean
   */
  private function setEndAngle($end_angle)
  {
    if (is_numeric($end_angle))
    {
      $this->end_angle = (int)$end_angle;

      return true;
    }

    return false;
  }

  /**
   * Gets the end angel
   *
   * @return integer
   */
  protected function getEndAngle()
  {
    return $this->end_angle;
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
   * Sets the color
   *
   * @param string
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

  /**
   * Sets the fill
   *
   * @param mixed
   * @return boolean
   */
  private function setFill($fill)
  {
    if (preg_match('/#[\d\w]{6}/',$fill) || (is_object($fill) && get_class($fill) === 'ImageTransform_Source'))
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

  /**
   * Sets the style
   *
   * @param integer
   * @return boolean
   */
  private function setStyle($style)
  {
    if (is_numeric($style))
    {
      $this->style = (int)$style;

      return true;
    }

    return false;
  }

  /**
   * Gets the style
   *
   * @return integer
   */
  protected function getStyle()
  {
    return $this->style;
  }
}
