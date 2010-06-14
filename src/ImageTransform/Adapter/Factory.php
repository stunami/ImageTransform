<?php
/**
 * This file is part of the ImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @category   ImageTransform
 * @package    Adapter
 * @version    $Id:$
 */

/**
 * Factory class for ImageTransform Adapters.
 *
 * @category   ImageTransform
 * @package    Adapter
 *
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Adapter_Factory
{
  const DEFAULT_ADAPTER = 'Gd';

  /**
   * Returns a adapter class of the specified type.
   * To improve performance all created instances are stored privatly.
   * The returned instance may be fresh if $clone = true was passed.
   *
   * @static
   * @access public
   *
   * @return ImageTransform_Adapter_Interface
   */
  public static function createAdapter($name = '')
  {
    // No adapter set so use default
    if ('' === $name)
    {
      $name = self::DEFAULT_ADAPTER;
    }

    $adapterClass = 'ImageTransform_Adapter_' . ucfirst($name);

    return new $adapterClass();
  }
}