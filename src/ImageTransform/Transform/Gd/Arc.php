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
class ImageTransform_Transform_Gd_Arc extends ImageTransform_Transform_Abstract_Arc
{
  /**
   * Apply the transform to the ImageTransform_Source object.
   *
   * @return ImageTransform_Souce
   */
  protected function transform()
  {
    $resource = $this->getResource();

    imagesetthickness($resource, $this->getThickness);

    if (!is_null($this->getFill()))
    {
      if (!is_object($this->getFill()))
      {
        imagefilledarc($resource, $this->getX(), $this->getY(), $this->getWidth(), $this->getHeight(), $this->getStartAngle(), $this->getEndAngle(), $this->getImage()->getAdapter()->getColorByHex($resource, $this->getFill()), $this->getStyle());
      }
      if ($this->color !== "" && $this->getFill() !== $this->color)
      {
        imagearc($resource, $this->getX(), $this->getY(), $this->getWidth(), $this->getHeight(), $this->getStartAngle(), $this->getEndAngle(), $this->getImage()->getAdapter()->getColorByHex($resource, $this->getColor()));
      }
    }
    else
    {
      imagearc($resource, $this->getX(), $this->getY(), $this->getWidth(), $this->getHeight(), $this->getStartAngle(), $this->getEndAngle(), $ $this->getImage()->getAdapter()->getColorByHex($resource, $this->getColor()));
    }

    return $this->getImage();
  }
}
