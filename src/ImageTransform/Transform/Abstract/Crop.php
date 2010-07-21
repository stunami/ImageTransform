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
 * Crops an image.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Transform_Abstract_Crop extends ImageTransform_Transform_Abstract
{
  /**
   * Left coordinate.
  */
  private $left = 0;

  /**
   * Top coordinate
  */
  private $top = 0;

  /**
   * Cropped area width.
  */
  private $width;

  /**
   * Cropped area height
  */
  private $height;

  /**
   * Construct an Crop object.
   *
   * @param integer
   * @param integer
   * @param integer
   * @param integer
   */
  public function __construct($left, $top, $width, $height)
  {
    $this->setLeft($left);
    $this->setTop($top);
    $this->setWidth($width);
    $this->setHeight($height);
  }

  /**
   * Sets the left coordinate
   *
   * @param integer
   */
  private function setLeft($left)
  {
    if (is_numeric($left))
    {
      $this->left = (int)$left;

      return true;
    }

    return false;
  }

  /**
   * returns the left coordinate
   *
   * @return integer
   */
  protected function getLeft()
  {
    return $this->left;
  }

  /**
   * set the top coordinate.
   *
   * @param integer
   */
  private function setTop($top)
  {
    if (is_numeric($top))
    {
      $this->top = (int)$top;

      return true;
    }

    return false;
  }

  /**
   * returns the top coordinate
   *
   * @return integer
   */
  protected function getTop()
  {
    return $this->top;
  }

  /**
   * set the width.
   *
   * @param integer
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
   * returns the width of the thumbnail
   *
   * @return integer
   */
  protected function getWidth()
  {
    return $this->width;
  }

  /**
   * set the height.
   *
   * @param integer
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
   * returns the height of the thumbnail
   *
   * @return integer
   */
  protected function getHeight()
  {
    return $this->height;
  }
}
