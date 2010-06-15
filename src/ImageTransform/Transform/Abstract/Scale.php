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
 * Scales an image by the set amount.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Transform_Abstract_Scale extends ImageTransform_Transform_Abstract
{

  /**
   * The amount to scale the image by.
   *
   * @var float
  */
  private $scale = 1;

  /**
   * Construct.
   *
   * @param float The scale factor
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
  private function setScale($scale)
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
  protected function getScale()
  {
    return $this->scale;
  }

}
