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
 * This class crops a image to a set size.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Gd
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_Gd_Crop extends ImageTransform_Transform_Abstract_Crop
{
  /**
   * Apply the transform to the image object.
   *
   * @return ImageTransform_Source
   */
  protected function transform()
  {
    $resource = $this->getResource();
    $dest_resource = $this->getImage()->getAdapter()->getTransparentImage($this->getWidth(), $this->getHeight());

    // Preserving transparency for alpha PNGs
    imagealphablending($dest_resource, false);
    imagesavealpha($dest_resource, true);

    imagecopy($dest_resource, $resource, 0, 0, $this->getLeft(), $this->getTop(), $this->getWidth(), $this->getHeight());

    // Tidy up
    imagedestroy($resource);

    // Replace old image with flipped version
    $this->getImage()->getAdapter()->setHolder($dest_resource);

    return $this->getImage();
  }
}
