<?php
/*
 * This file is part of the sfImageTransform package.
 * (c) 2007 Stuart <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * sfImageOverlaysGD class.
 *
 * Overlays GD image on top of another GD image.
 *
 * Overlays an image at a set point on the image.
 *
 * @package sfImageTransform
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @version SVN: $Id$
 */
class sfImageOverlayGD extends sfImageTransformAbstract
{

  /**
   * The overlay sfImage.
  */
  protected $overlay;

  /**
   * The opacity applied to the overlay.
  */
  protected $opacity = 10;

  /**
   * The left coordinate for the overlay position.
  */
  protected $left = 0;

  /**
   * The top coordinate for the overlay position.
  */
  protected $top = 0;

  /**
   * Construct an sfImageOverlay object.
   *
   * @param array mixed
   */
  public function __construct(sfImage $overlay, $left=0, $top=0, $opacity=10) {

    $this->setOverlay($overlay);
    $this->setOpacity($opacity);
    $this->setLeft($left);
    $this->setTop($top);
  }

  /**
   * sets the over image.
   *
   * @param sfImage
   */
  function setOverlay(sfImage $overlay)
  {
    $this->overlay = $overlay;

  }

  /**
   * returns the overlay sfImage object.
   *
   * @return sfImage
   */
  function getOverlay()
  {
    return $this->overlay;
  }

  /**
   * Sets the left coordinate
   *
   * @param integer
   */
  public function setLeft($left)
  {
    $this->left = $left;
  }

  /**
   * returns the left coordinate.
   *
   * @return integer
   */
  public function getLeft()
  {
    return $this->left;
  }

  /**
   * set the top coordinate.
   *
   * @param integer
   */
  public function setTop($top)
  {
    $this->top = $top;
  }

  /**
   * returns the top coordinate.
   *
   * @return integer
   */
  public function getTop()
  {
    return $this->top;
  }

  /**
   * sets the opacity used for the overlay.
   *
   * @param integer
   */
  function setOpacity($opacity)
  {
    if(is_numeric($opacity) && $opacity > 0)
    {
      $this->opacity = $opacity;
    }
  }

  /**
   * returns the opacity used for the overlay.
   *
   * @return integer
   */
  function getOpacity()
  {
    return $this->opacity;
  }

  /**
   * Apply the transform to the sfImage object.
   *
   * @param integer
   * @return sfImage
   */
  protected function transform(sfImage $image)
  {

    $resource = $image->getAdapter()->getHolder();

    // create true color canvas image:
    $canvas_w = ImageSX($resource);
    $canvas_h = ImageSY($resource);
    $canvas_img = imagecreatetruecolor($canvas_w, $canvas_h);
    //imagealphablending($resource,true);

    imagecopy($canvas_img, $resource, 0,0,0,0, $canvas_w, $canvas_h);

    // Check we have a valid image resource
    if(false === $this->overlay->getAdapter()->getHolder())
    {
      throw new sfImageTransformException(sprintf('Cannot perform transform: %s',get_class($this)));
    }

    // create true color overlay image:
    $overlay_w = ImageSX($this->overlay->getAdapter()->getHolder());
    $overlay_h = ImageSY($this->overlay->getAdapter()->getHolder());

    $overlay_img = imagecreatetruecolor($overlay_w, $overlay_h);

    imagecopy($overlay_img, $this->overlay->getAdapter()->getHolder(), 0,0,0,0, $overlay_w, $overlay_h);
    //imagealphablending($overlay_img,true); 
    //imagecolortransparent($overlay_img, imagecolorallocate($overlay_img, 0xFF, 0xFF, 0xFF));

    // copy and merge the overlay image and the canvas image:
    imagecopymerge($canvas_img, $overlay_img, $this->left,$this->top,0,0, $overlay_w, $overlay_h, $this->opacity);

    // tidy up
    imagedestroy($overlay_img);
    imagedestroy($resource);

    $image->getAdapter()->setHolder($canvas_img);
    return $image;

  }
}
