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
 * Resizes the image to the set size.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Gd
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_Gd_ResizeSimple extends ImageTransform_Transform_Abstract_Resize
{
  /**
   * Apply the transform to the sfImage object.
   *
   * @return ImageTransform_Source
   */
  protected function transform()
  {
    $image = $this->getImage();
    $resource = $this->getResource();

    $x = imagesx($resource);
    $y = imagesy($resource);

    // If the width or height is not valid then enforce the aspect ratio
    if (!is_numeric($this->getWidth()) || $this->getWidth() < 1)
    {
      $this->setWidth(round(($x / $y) * $this->getHeight()));
    }

    else if (!is_numeric($this->getHeight()) || $this->getHeight() < 1)
    {
      $this->setHeight(round(($y / $x) * $this->getWidth()));
    }

    $dest_resource = $image->getAdapter()->getTransparentImage($this->getWidth(), $this->getHeight());

    // Preserving transparency for alpha PNGs
    if ($image->getMIMEType() == 'image/png')
    {
      imagealphablending($dest_resource, false);
      imagesavealpha($dest_resource, true);
    }

    // Finally do our resizing
    imagecopyresampled($dest_resource,$resource,0, 0, 0, 0, $this->getWidth(), $this->getHeight(),$x, $y);
    imagedestroy($resource);

    $image->getAdapter()->setHolder($dest_resource);

    return $image;
  }
}
