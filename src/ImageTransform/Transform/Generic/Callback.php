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
 * @subpackage Generic
 * @version    $Id:$
 */

/**
 * Callback transform
 *
 * Allows the calling of external methods or functions as a transform
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Generic
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_Generic_Callback extends ImageTransform_Transform_Abstract_Callback
{
  /**
   * @return ImageTransform_Source
   */
  public function transform()
  {
    $image = $this->getImage();

    call_user_func_array($this->getFunction(), array('image' => $image, 'arguments' => $this->getArguments()));

    return $image;
  }
}