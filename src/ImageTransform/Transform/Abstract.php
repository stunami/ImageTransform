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
 * Base class from ImageTransform_Transform implementations
 *
 * @category   ImageTransform
 * @package    Transform
 *
 * @author Miloslav Kmet <miloslav.kmet@gmail.com>
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Transform_Abstract implements ImageTransform_Transform_Interface
{
  /**
   * Apply the transform to the sfImage object.
   *
   * @param ImageTransform_Source
   * @return ImageTransform_Source
   */
  public function execute(ImageTransform_Source $image)
  {
    // Check we have a valid image holder
    if (false === $image->getAdapter()->hasHolder())
    {
      $message = 'Cannot perform transform: %s invalid image resource';
      throw new ImageTransform_Transform_Exception(sprintf($message, get_class($this)));
    }
    return $this->transform($image);
  }

  abstract protected function transform(ImageTransform_Source $image);
}
