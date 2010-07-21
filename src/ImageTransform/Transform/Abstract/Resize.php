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
 * generic resize transform
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Miloslav Kmet <miloslav.kmet@gmail.com>
 * @author Victor Berchet <vberchet-sf@yahoo.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Transform_Abstract_Resize extends ImageTransform_Transform_Abstract
{
  /**
   * width of the target
   */
  private $width = 0;

  /**
   * height of the target
   */
  private $height = 0;

  /**
   * constructor
   *
   * @param integer $width of the thumbnail
   * @param integer $height of the thumbnail
   * @return void
   */
  public function __construct($width, $height)
  {
    $this->setWidth($width);
    $this->setHeight($height);
  }

  /**
   * sets the height of the thumbnail
   * @param integer $height of the image
   *
   * @return void
   */
  protected function setHeight($height)
  {
    if (is_numeric($height) && $height > 0)
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

  /**
   * sets the width of the thumbnail
   * @param integer $width of the image
   *
   * @return void
   */
  protected function setWidth($width)
  {
    if (is_numeric($width) && $width > 0)
    {
      $this->width = (int)$width;

      return false;
    }
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
}
