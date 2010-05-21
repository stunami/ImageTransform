<?php
/*
 * This file is part of the sfImageTransform package.
 * (c) 2007 Stuart <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * BaseImageTransformReflection class
 *
 * adds a mirrored reflection effect to an image
 *
 * @package sfImageTransform
 * @subpackage transforms
 * @author Stuard Lowes <stuart.lowes@gmail.com>
 * @author Colin MacDonald <colin@oneweb.co.uk>
 *
 * @version SVN: $Id$
 */
class BaseImageTransformReflection extends BaseImageTransform
{
	 /**
   * The reflection height for the image
   */
  protected $reflection_height = 20;

	 /**
   * The starting transparency
   */
  protected $start_transparency = 30;

  /**
   * Constructor of an sfImageReflection transformation
   *
   * @param float $reflection_height
   */
  public function __construct($reflection_height=20, $start_transparency=30)
  {
    $this->setReflectionHeight($reflection_height);
    $this->setStartTransparency($start_transparency);
  }

  /**
   * Sets the reflection height
   * @param int $reflection_height
   * @return boolean
   */
  public function setReflectionHeight($reflection_height)
  {
    if (is_numeric($reflection_height))
    {
      $this->reflection_height = (int)$reflection_height;
      return true;
    }

    return false;
  }

  /**
   * Gets the reflection height
   * @param int $reflection_height
   * @return integer
   */
  public function getReflectionHeight()
  {
    return $this->reflection_height;
  }

  /**
   * Sets the start transparency
   * @param int $start_transparency
   * @return boolean
   */
  public function setStartTransparency($start_transparency)
  {
    if (is_numeric($start_transparency))
    {
      $this->start_transparency = (int)$start_transparency;
      return true;
    }

    return false;
  }

  /**
   * Gets the start transparency
   * @param int $start_transparency
   * @return integer
   */
  public function getStartTransparency()
  {
    return $this->start_transparency;
  }

  /**
   * Apply the opacity transformation to the sfImage object
   *
   * @param sfImage
   *
   * @return sfImage
   */
  public function transform(sfImage $image)
  {
    return $image;
  }
}
