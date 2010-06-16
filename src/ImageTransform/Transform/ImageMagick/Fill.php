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
 * @subpackage Gd
 * @version    $Id:$
 */

/**
 * Fills the set area with a color or tile image.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Gd
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_ImageMagick_Fill extends ImageTransform_Transform_Abstract_Fill
{
  /**
   * Fuzz
   *
   * @var integer
   */
  private $fuzz = 0;

  /**
   * Border
   *
   * @var String
   */
  private $border = null;

  /**
   * Construct an image object.
   *
   * @param integer
   * @param integer
   * @param String/object hex color
   * @param integer
   * @param String/object hex color
   */
  public function __construct($x=0, $y=0, $fill='#000000', $fuzz=0, $border=null)
  {
    parent::__construct($x, $y, $fill);

    $this->setFuzz($fuzz);
    $this->setBorder($border);
  }

  /**
   * Sets the fill
   *
   * @param string
   * @return boolean
   */
  protected function setFill($fill)
  {
    if (!is_string($fill))
    {
      throw new ImageTransform_Transform_Exception('Fill option must be string for ImageMagick adapter!');
    }

    return parent::setFill($fill);
  }

  /**
   * Sets the fuzz
   *
   * @param integer $fuzz
   * @return boolean
   */
  private function setFuzz($fuzz)
  {
    if (is_numeric($fuzz))
    {
      $this->fuzz = (int)$fuzz;

      return true;
    }

    return false;
  }

  /**
   * Gets the fuzz
   *
   * @return integer
   */
  private function getFuzz()
  {
    return $this->fuzz;
  }

  /**
   * Sets the border colour.
   *
   * @param String $border
   * @return boolean
   */
  private function setBorder($border)
  {
    if (preg_match('/#[\d\w]{6}/',$border))
    {
      $this->border = $border;

      return true;
    }

    return false;
  }

  /**
   * Gets the border colour.
   *
   * @return String
   */
  private function getBorder()
  {
    return $this->border;
  }

  /**
   * Apply the transform to the sfImage object.
   *
   * @param sfImage
   * @return sfImage
   */
  protected function transform()
  {
    $resource = $this->getResource();

    $fill = new ImagickPixel();
    $fill->setColor($this->getFill());

    /*
     *  colorFloodfillImage has been depricated, use new method if available
     */
    if (method_exists($resource, 'floodFillPaintImage') && is_null($this->getBorder()))
    {
      $target = $resource->getImagePixelColor($this->getX(), $this->getY());
      $resource->floodFillPaintImage($fill, $this->getFuzz(), $target, $this->getX(), $this->getY(), false);
    }
    else
    {
      $border = new ImagickPixel();
      $border->setColor($this->getBorder());

      $resource->colorFloodfillImage($fill, $this->getFuzz(), $border, $this->getX(), $this->getY());
    }

    return $this->getImage();
  }
}
