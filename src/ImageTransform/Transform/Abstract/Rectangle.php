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
 * Draws a rectangle on an image.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Tranform_Abstract_Rectangle extends ImageTransform_Transform_Abstract
{
  /**
   * Start X coordinate.
   *
   * @var integer
  */
  protected $x1 = 0;

  /**
   * Start Y coordinate.
   *
   * @var integer
  */
  protected $y1 = 0;

  /**
   * Finish X coordinate.
   *
   * @var integer
  */
  protected $x2 = 0;

  /**
   * Finish Y coordinate
   *
   * @var integer
  */
  protected $y2 = 0;

  /**
   * Rectangle thickness.
   *
   * @var integer
  */
  protected $thickness = 1;

  /**
   * Hex color.
   *
   * @var string
  */
  protected $color = '';

  /**
   * Fill.
   *
   * @var string/object hex or ImageTransform_Source object
  */
  protected $fill = null;

  /**
   * Construct an sfImageBlur object.
   *
   * @param integer
   * @param integer
   * @param integer
   * @param integer
   * @param integer
   * @param integer
   * @param string/object hex or ImageTransform_Source object
   * @param integer
   */
  public function __construct($x1, $y1, $x2, $y2, $thickness=1, $color=null, $fill=null)
  {
    $this->setStartX($x1);
    $this->setStartY($y1);
    $this->setEndX($x2);
    $this->setEndY($y2);
    $this->setThickness($thickness);
    $this->setColor($color);
    $this->setFill($fill);
  }

  /**
   * Sets the start X coordinate
   *
   * @param integer
   * @return boolean
   */
  public function setStartX($x)
  {
    if (is_numeric($x))
    {
      $this->x1 = (int)$x;

      return true;
    }

    return false;
  }

  /**
   * Gets the start X coordinate
   *
   * @return integer
   */
  public function getStartX()
  {
    return $this->x1;
  }

  /**
   * Sets the start Y coordinate
   *
   * @param integer
   * @return boolean
   */
  public function setStartY($y)
  {
    if (is_numeric($y))
    {
      $this->y1 = (int)$y;

      return true;
    }

    return false;
  }

  /**
   * Gets the Y coordinate
   *
   * @return integer
   */
  public function getStartY()
  {
    return $this->y1;
  }

  /**
   * Sets the end X coordinate
   *
   * @param integer
   * @return boolean
   */
  public function setEndX($x)
  {
    if (is_numeric($x))
    {
      $this->x2 = (int)$x;

      return true;
    }

    return false;
  }

  /**
   * Gets the end X coordinate
   *
   * @return integer
   */
  public function getEndX()
  {
    return $this->x2;
  }

  /**
   * Sets the end Y coordinate
   *
   * @param integer
   * @return boolean
   */
  public function setEndY($y)
  {
    if (is_numeric($y))
    {
      $this->y2 = (int)$y;

      return true;
    }

    return false;
  }

  /**
   * Gets the end Y coordinate
   *
   * @return integer
   */
  public function getEndY()
  {
    return $this->y2;
  }

  /**
   * Sets the thickness
   *
   * @param integer
   * @return boolean
   */
  public function setThickness($thickness)
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
  public function getThickness()
  {
    return $this->thickness;
  }

  /**
   * Sets the color
   *
   * @param string
   * @return boolean
   */
  public function setColor($color)
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
  public function getColor()
  {
    return $this->color;
  }

  /**
   * Sets the fill
   *
   * @param mixed
   * @return boolean
   */
  public function setFill($fill)
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
  public function getFill()
  {
    return $this->fill;
  }
}
