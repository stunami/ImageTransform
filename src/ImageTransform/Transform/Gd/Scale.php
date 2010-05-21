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
 * Scales an image by the set amount.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Gd
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_Gd_Scale extends ImageTransform_Transform_Abstract
{
  /**
   * The amount to scale the image by.
   *
   * @var float
  */
  protected $scale = 1;

  /**
   * Construct an sfImageScale object.
   *
   * @param float
   */
  public function __construct($scale)
  {
    $this->setScale($scale);
  }

  /**
   * Set the scale factor.
   *
   * @param float
   */
  public function setScale($scale)
  {
    if (is_numeric($scale))
    {
      $this->scale = $scale;
    }
  }

  /**
   * Gets the scale factor.
   *
   * @return float
   */
  public function getScale()
  {
    return $this->scale;
  }

  /**
   * Apply the transform to the sfImage object.
   *
   * @param ImageTransform_Source
   * @return ImageTransform_Source
   */
  protected function transform(ImageTransform_Source $image)
  {
    $resource = $image->getAdapter()->getHolder();

    $x = imagesx($resource);
    $y = imagesy($resource);

    $image->resize(round($x * $this->scale),round($y * $this->scale));

    return $image;
  }
}
