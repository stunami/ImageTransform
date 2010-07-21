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
 * Blurs an image.
 *
 * Reduces the level of detail of the image. Slower than Guassian and Selective Blur
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Transform_Abstract_PixelBlur extends ImageTransform_Transform_Abstract
{
  /**
   * The number of pixels used for the blur.
   * @var integer
  */
  private $blur_pixels = 1;

  /**
   * Construct an Blur object.
   *
   * @param array integer
   */
  public function __construct($blur=1)
  {
    $this->setBlur($blur);
  }

  /**
   * Set the number of pixels to be read when calculating.
   *
   * @param integer
   * @return boolean
   */
  private function setBlur($pixels)
  {
    if (is_numeric($pixels))
    {
      $this->blur_pixels = $pixels;

      return true;
    }

    return false;
  }

  /**
   * Returns the number of pixels to be read when calculating.
   *
   * @return integer
   */
  protected function getBlur()
  {
    return $this->blur_pixels;
  }
}
