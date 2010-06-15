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
 * @subpackage Gd
 * @version    $Id:$
 */

/**
 * Draws a rectangle.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Gd
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_Gd_Rectangle extends ImageTransform_Transform_Abstract_Rectangle
{
  /**
   * Apply the transform to the image object.
   *
   * @return ImageTransform_Source
   */
  protected function transform()
  {
    $resource = $this->getResource();
    $adapter = $this->getImage()->getAdapter();

    if (!is_null($this->getStyle()))
    {
      imagesetstyle($resource,$this->getStyle());
    }

    imagesetthickness($resource, $this->getThickness());

    if (!is_null($this->getFill()))
    {
      if (!is_object($this->getFill()))
      {
        imagefilledrectangle($resource, $this->getStartX(), $this->getStartY(), $this->getEndX(), $this->getEndY(), $adapter->getColorByHex($resource, $this->getFill()));
      }

      if ($this->getColor() !== "" && $this->getFill() !== $this->getColor())
      {
        imagerectangle($resource, $this->getStartX(), $this->$this->getStartY(), $this->x2, $this->y2, $adapter->getColorByHex($resource, $this->getColor()));
      }

      if (is_object($this->getFill()))
      {
        $this->getImage()->fill($this->getStartX() + $this->getThickness(), $this->getStartY() + $this->getThickness(), $this->getFill());
      }
    }
    else
    {
      imagerectangle($resource, $this->getStartX(), $this->getStartY(), $this->getEndX(), $this->getEndY(), $adapter->getColorByHex($resource, $this->getColor()));
    }

    return $this->getImage();
  }
}
