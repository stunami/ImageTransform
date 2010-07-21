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
 * Overlays GD image on top of another GD image.
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Gd
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_Gd_Overlay extends ImageTransform_Transform_Abstract_Overlay
{
  /**
   * Apply the transform to the sfImage object.
   *
   * @return ImageTransform_Source
   */
  protected function transform()
  {
    // compute the named coordinates
    $this->computeCoordinates();

    $image = $this->getImage();
    $resource = $this->getResource();

    // create true color canvas image:
    $canvas_w = $image->getWidth();
    $canvas_h = $image->getHeight();
    $canvas_img = $image->getAdapter()->getTransparentImage($canvas_w, $canvas_h);
    imagecopy($canvas_img, $resource, 0,0,0,0, $canvas_w, $canvas_h);

    // Check we have a valid image resource
    if (false === $this->getOverlay()->getAdapter()->getHolder())
    {
      throw new ImageTransform_Transform_Gd_Exception(sprintf('Cannot perform transform: %s',get_class($this)));
    }

    // create true color overlay image:
    $overlay_w   = $this->getOverlay()->getWidth();
    $overlay_h   = $this->getOverlay()->getHeight();
    $overlay_img = $this->getOverlay()->getAdapter()->getHolder();

    // copy and merge the overlay image and the canvas image:
    imagecopy($canvas_img, $overlay_img, $this->getLeft(),$this->getTop(),0,0, $overlay_w, $overlay_h);

    // tidy up
    imagedestroy($resource);
    $image->getAdapter()->setHolder($canvas_img);

    return $image;
  }
}
