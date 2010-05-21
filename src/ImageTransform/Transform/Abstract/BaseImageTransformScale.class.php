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
 * BaseImageTransformScale class.
 *
 * Scales the image.
 *
 * Scales an image by the set amount.
 *
 * @package sfImageTransform
 * @subpackage transforms
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @version SVN: $Id$
 */
class BaseImageTransformScale extends BaseImageTransform
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
   * @param sfImage
   * @return sfImage
   */
  protected function transform(sfImage $image)
  {
    return $image;
  }
}
