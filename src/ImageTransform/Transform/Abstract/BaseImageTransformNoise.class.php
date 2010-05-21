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
 * ImageTransformNoiseGD class.
 *
 * Adds noise to the GD image.
 *
 * Reduces the level of detail of an image.
 *
 * @package sfImageTransform
 * @subpackage transforms
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @version SVN: $Id$
 */
class ImageTransformNoiseGD extends BaseImageTransformNoise
{
  /**
   * Noise density.
  */
  protected $density = 20;

  /**
   * Construct an sfImageDuotone object.
   *
   * @param integer
   */
  public function __construct($density=20)
  {
    $this->setDensity($density);
  }

  /**
   * Sets the density
   *
   * @param integer
   * @return boolean
   */
  public function setDensity($density)
  {
    if (is_numeric($density))
    {
      $this->density = (int)$density;

      return true;
    }

    return false;
  }

  /**
   * Gets the density
   *
   * @return integer
   */
  public function getdensity()
  {
    return $this->density;
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
