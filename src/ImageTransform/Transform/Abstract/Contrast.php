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
 * Sets the contrast of an image.
 * 
 * Reduces the level of detail of an image.
 * 
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */  
abstract class ImageTransform_Transform_Abstract_Contrast extends ImageTransform_Transform_Abstract
{
  /**
   * Constract level to be applied.
  */
  protected $contrast = 0;

  /**
   * Construct an sfImageContrast object.
   *
   * @param integer
   */
  public function __construct($contrast)
  {
    $this->setContrast($contrast);
  }

  /**
   * Sets the contrast
   *
   * @param integer
   * @return boolean
   */
  public function setContrast($contrast)
  {
    if (is_numeric($contrast))
    {
      $this->contrast = (int)$contrast;

      return true;
    }

    return false;
  }

  /**
   * Gets the contrast
   *
   * @return integer
   */
  public function getContrast()
  {
    return $this->contrast;
  }
}
