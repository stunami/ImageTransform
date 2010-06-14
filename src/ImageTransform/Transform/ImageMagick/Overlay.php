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
 * Overlays an image at a set point on the image.
 *
 * @package ImageTransform
 * @subpackage transforms
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_ImageMagic_Overlay extends ImageTransform_Transform_Abstract_Overlay
{
  /**
   * The composite operator
   */
  private $compose = IMagick::COMPOSITE_DEFAULT;

  /**
   * The opacity applied to the overlay.
   */
  private $opacity = null;

  /**
   * Construct an sfImageOverlay object.
   *
   * @param ImageTransform_Source $overlay  - the image for the overlay
   * @param mixed                 $position - the named position as string, or the array of exact coordinates
   * @param float                 $opacity  - the opacity for the overlay image
   * @param integer               $compose  - the composite operator
   *
   * @return void
   */
  public function __construct(ImageTransform_Source $overlay,  $position='top-left', $opacity=null, $compose=null)
  {
    $this->setOpacity($opacity);
    $this->setCompose($compose);

    parent::__construct($opacity, $position);
  }

  /**
   * sets the opacity used for the overlay.
   *
   * @param integer
   */
  private function setOpacity($opacity)
  {
    if (is_numeric($opacity) && $opacity > 1)
    {
      $this->opacity = $opacity / 100;
    }

    else if (is_float($opacity))
    {
      $this->opacity = abs($opacity);
    }

    else
    {
      $this->opacity = $opacity;
    }
  }

  /**
   * returns the opacity used for the overlay.
   *
   * @return mixed
   */
  private function getOpacity()
  {
    return $this->opacity;
  }

  /**
   * Sets the composite operator
   *
   * @param integer valid IMagick composite opeator
   *
   * @return void
   * @see http://php.net/manual/en/imagick.constants.php#imagick.constants.compositeop
   */
  private function setCompose($compose=IMagick::COMPOSITE_DEFAULT)
  {
    if (is_null($compose))
    {
      $compose = IMagick::COMPOSITE_DEFAULT;
    }

    $this->compose = $compose;
  }

  /**
   * return the composite operator
   *
   * @return integer composite operator
   */
  private function getCompose()
  {
    return $this->compose;
  }


  /**
   * Apply the transform to the sfImage object.
   *
   * @param sfImage
   *
   * @return sfImage
   */
  protected function transform(sfImage $image)
  {
    // compute the named coordinates
    $this->computeCoordinates($image);

    $resource = $image->getAdapter()->getHolder();
    $overlay = $this->getOverlay();

    if (!is_null($this->getOpacity()))
    {
      $overlay->getAdapter()->getHolder()->setImageOpacity($this->getOpacity());
    }

    $resource->compositeImage($overlay->getAdapter()->getHolder(), $this->getCompose(), $this->getLeft(), $this->getTop());

    $image->getAdapter()->setHolder($resource);

    return $image;
  }
}
