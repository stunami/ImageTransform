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
 * Adds text to the image.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Transform_Abstract_Text extends ImageTransform_Transform_Abstract
{
  /**
   * Font face.
  */
  private $font = 'Arial';

  /**
   * Font size.
  */
  private $size = 10;

  /**
   * Text.
  */
  private $text = '';

  /**
   * Angel of the text.
  */
  private $angle = 0;

  /**
   * X coordinate.
  */
  private $x = 0;

  /**
   * Y coordinate.
  */
  private $y = 0;

  /**
   * Font Color.
  */
  private $color = '#000000';

  /**
   * Path to font.
  */
  private $font_dir = '/usr/share/fonts/truetype/msttcorefonts';

  /**
   * Construct an Text object.
   *
   * @param array integer
   */
  public function __construct($text, $x=0, $y=0, $size=10, $font='Arial', $color='#000000', $angle=0, $fontDir = '')
  {
    if ($fontDir)
    {
      $this->font_dir = $fontDir;
    }
    $this->setText($text);
    $this->setX($x);
    $this->setY($y);
    $this->setSize($size);
    $this->setFont($font);
    $this->setColor($color);
    $this->setAngle($angle);
  }

  /**
   * Sets the text.
   *
   * @param string
   */
  private function setText($text)
  {
    $this->text = $text;
  }

  /**
   * Gets the text.
   *
   * @return string
   */
  protected function getText()
  {
    return $this->text;
  }

  /**
   * Sets X coordinate.
   *
   * @param integer
   */
  private function setX($x)
  {
    $this->x = $x;
  }

  /**
   * Gets X coordinate.
   *
   * @return integer
   */
  protected function getX()
  {
    return $this->x;
  }

  /**
   * Sets Y coordinate.
   *
   * @param integer
   */
  private function setY($y)
  {
    $this->y = $y;
  }

  /**
   * Gets Y coordinate.
   *
   * @return integer
   */
  protected function getY()
  {
    return $this->y;
  }

  /**
   * Sets text size.
   *
   * @param integer
   */
  private function setSize($size)
  {
    $this->size = $size;
  }

  /**
   * Gets text size.
   *
   * @return integer
   */
  protected function getSize()
  {
    return $this->size;
  }

  /**
   * Sets text font.
   *
   * @param string
   */
  private function setFont($font)
  {
    $this->font = str_replace(' ', '_', $font);
  }

  /**
   * Gets text font.
   *
   * @return string
   */
  protected function getFont()
  {
    return $this->font;
  }

  /**
   * Sets text color.
   *
   * @param string
   */
  private function setColor($color)
  {
    $this->color = $color;
  }

  /**
   * Gets text color.
   *
   * @return string
   */
  protected function getColor()
  {
    return $this->color;
  }

  /**
   * Sets text angle.
   *
   * @param string
   */
  private function setAngle($angle)
  {
    $this->angle = $angle;
  }

  /**
   * Gets text angle.
   *
   * @return string
   */
  protected function getAngle()
  {
    return $this->angle;
  }
}
