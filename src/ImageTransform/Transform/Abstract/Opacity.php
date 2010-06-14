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
 * Changes the opacity of an image
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Miloslav Kmet <miloslav.kmet@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Transform_Abstract_Opacity extends ImageTransform_Transform_Abstract
{
  /**
   * The opacity applied to the image
   */
  private $opacity = 1;

  /**
   * Constructor of an Opacity transformation
   *
   * @param float $opacity If greater than 1, will be divided by 100
   */
  public function __construct($opacity)
  {
    $this->setOpacity($opacity);
  }

  /**
   * sets the opacity
   * @param float $opacity Image between 0 and 1. If $opacity > 1, will be diveded by 100
   * @return void
   */
  private function setOpacity($opacity)
  {
    if (is_numeric($opacity) or is_float($opacity))
    {
      if ($opacity < 1)
      {
        $this->opacity  = $opacity * 100;
      }

      else
      {
        $this->opacity = $opacity;
      }
      $this->opacity   = 100 - $opacity;
    }
  }

  /**
   * returns the current opacity
   *
   * @return float opacity
   */
  protected function getOpacity()
  {
    return $this->opacity;
  }
}
