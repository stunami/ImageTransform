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
 * Base tranform to set the brightnes of an image.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Tranform_Abstract_Brightness extends ImageTransform_Transform_Abstract
{
  /**
   * Constract level to be applied.
  */
  protected $brightness = 0;

  /**
   * Construct an sfImageBrightness object.
   *
   * @param integer
   */
  public function __construct($brightness)
  {
    $this->setBrightness($brightness);
  }

  /**
   * Sets the brightness
   *
   * @param integer
   * @return boolean
   */
  public function setBrightness($brightness)
  {
    if (is_numeric($brightness))
    {
      $this->brightness = (int)$brightness;

      return true;
    }

    return false;
  }

  /**
   * Gets the brightness
   *
   * @return integer
   */
  public function getBrightness()
  {
    return $this->brightness;
  }
}
