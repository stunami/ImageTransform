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
 *
 * Interface for ImageTransform Transform implementations
 *
 * @category   ImageTransform
 * @package    Transform
 *
 * @author Jan Schumann <js@schumann-it.com>
 */
interface ImageTransform_Transform_Interface
{
  /**
   * Performs the image transformation.
   *
   * @param ImageTransform_Source
   * @return ImageTransform_Source
   */
  function execute(ImageTransform_Source $image);
}