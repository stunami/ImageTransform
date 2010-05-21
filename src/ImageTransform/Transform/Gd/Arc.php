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
 * GD implementation of arc
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Gd
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Tranform_Gd_Arc extends ImageTransform_Tranform_Abstract_Arc
{
  /**
   * Apply the transform to the ImageTransform_Source object.
   *
   * @param ImageTransform_Source
   * @return ImageTransform_Source
   */
  protected function transform(ImageTransform_Source $image)
  {
    $resource = $image->getAdapter()->getHolder();

    imagesetthickness($resource, $this->thickness);

    if (!is_null($this->fill))
    {
      if (!is_object($this->fill))
      {
        imagefilledarc($resource, $this->x, $this->y, $this->width, $this->height, $this->start_angle, $this->end_angle, $image->getAdapter()->getColorByHex($resource, $this->fill), $this->style);
      }
      if ($this->color !== "" && $this->fill !== $this->color)
      {
        imagearc($resource, $this->x, $this->y, $this->width, $this->height, $this->start_angle, $this->end_angle, $image->getAdapter()->getColorByHex($resource, $this->color));
      }
    }
    else
    {
      imagearc($resource, $this->x, $this->y, $this->width, $this->height, $this->start_angle, $this->end_angle, $image->getAdapter()->getColorByHex($resource, $this->color));
    }

    return $image;
  }
}
