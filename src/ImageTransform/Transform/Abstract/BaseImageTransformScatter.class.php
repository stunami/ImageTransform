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
 * BaseImageTransformScatter class.
 *
 * Scatters the image pixels.
 *
 * Gives the image a disintegrated look
 *
 * @package sfImageTransform
 * @subpackage transforms
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @version SVN: $Id$
 */
class BaseImageTransformScatter extends BaseImageTransform
{
  /**
   * Scatter factor.
  */
  protected $scatter_factor = 4;

  /**
   * Construct an sfImageDuotone object.
   *
   * @param integer
   */
  public function __construct($scatter=4)
  {
    $this->setScatterFactor($scatter);
  }

  /**
   * Set the scatter factor.
   *
   * @param integer
   */
  public function setScatterFactor($width)
  {
    $this->width = (int)$width;
  }

  /**
   * Gets the scatter factor
   *
   * @return integer
   */
  public function getScatterFactor()
  {
    return $this->width;
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
