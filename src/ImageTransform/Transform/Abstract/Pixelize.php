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
 * Pixelizes an image.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Abstract
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Tranform_Abstract_Pixelize extends ImageTransform_Transform_Abstract
{
  /**
   * The size of the pixelization.
  */
  protected $block_size = 10;

  /**
   * Construct an sfImagePixelize object.
   *
   * @param array integer
   */
  public function __construct($size=10)
  {
    $this->setSize($size);
  }

  /**
   * Set the pixelize blocksize.
   *
   * @param integer
   * @return boolean
   */
  public function setSize($pixels)
  {
    if (is_numeric($pixels) && $pixels > 0)
    {
      $this->block_size = (int)$pixels;

      return true;
    }

    return false;
  }

  /**
   * Returns the pixelize blocksize.
   *
   * @return integer
   */
  public function getSize()
  {
    return $this->block_size;
  }
}
