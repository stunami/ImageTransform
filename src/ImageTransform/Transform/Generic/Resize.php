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
 * @subpackage Generic
 * @version    $Id:$
 */

/**
 * generic resize transform
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Generic
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Miloslav Kmet <miloslav.kmet@gmail.com>
 * @author Victor Berchet <vberchet-sf@yahoo.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_Generic_Resize extends ImageTransform_Transform_Abstract_Resize
{
  /**
   * do we want to inflate the source image ?
   * @var bool
   */
  private $inflate = true;

  /**
   * do we want to keep the aspect ratio of the source image ?
   * @var bool
   */
  private $proportinal = false;

  /**
   * The width of the image to transform
   * @var int
   */
  private $source_w;
  /**
   * The hight of the image to transform
   * @var int
   */
  private $source_h;
  /**
   * The width of the transformed image
   * @var int
   */
  private $target_w;
  /**
   * The hight of the transformed image
   * @var int
   */
  private $target_h;

  /**
   * constructor
   *
   * @param integer $width of the thumbnail
   * @param integer $height of the thumbnail
   * @param boolean could the target image be larger than the source ?
   * @param boolean should the target image keep the source aspect ratio ?
   *
   * @return void
   */
  public function __construct($width, $height, $inflate = true, $proportional = false)
  {
    parent::__construct($width, $height);

    $this->setInflate($inflate);
    $this->setProportional($proportional);
  }

  /**
   * Choose if inflate is enabled or not
   * @param boolean
   *
   * @return boolean true if the parameter is valid
   */
  private function setInflate($inflate)
  {
    if (is_bool($inflate))
    {
      $this->inflate = $inflate;

      return true;
    }

    return false;
  }

  /**
   * returns the state of inflate
   *
   * @return boolean
   */
  private function getInflate()
  {
    return $this->inflate;
  }

  /**
   * Choose if the aspect ratio should be preserved
   * @param boolean
   *
   * @return boolean true if the parameter is valid
   */
  private function setProportional($proportional)
  {
    if (is_bool($proportional))
    {
      $this->proportional = $proportional;

      return true;
    }

    return false;
  }

  /**
   * returns the state of aspect ratio
   *
   * @return boolean
   */
  private function getProportional()
  {
    return $this->proportional;
  }

  /**
   * Apply the transformation to the image and returns the resized image
   *
   * @return ImageTransform_Source
   */
  protected function transform()
  {
    $image = $this->getImage();

    $this->target_w = $this->source_w = $image->getWidth();
    $this->target_h = $this->source_h = $image->getHeight();

    $this->computeTargetSize();

    return $image->resizeSimple($this->target_w, $this->target_h);
  }

  /**
   * Compute target size
   */
  private function computeTargetSize()
  {
    $this->handleWidth();
    $this->handleHeight();
  }

  /**
   * Computes target size for width
   */
  private function handleWidth()
  {
    if (is_null($this->getWidth()))
    {
      return;
    }

    $this->target_w = $this->getWidth();
    if (!$this->getInflate() && $this->target_w > $this->source_w)
    {
      $this->target_w = $this->source_w;
    }

    if ($this->getProportional() && $this->source_w > 0)
    {
      // Compute the new height in order to keep the aspect ratio
      // and clamp it to the maximum height
      $this->target_h = round(($this->source_h / $this->source_w) * $this->target_w);

      if (null !== $this->getHeight() && $this->getHeight() < $this->target_h && $this->source_h > 0)
      {
        $this->target_h = $this->getHeight();
        $this->target_w = round(($this->source_w / $this->source_h) * $this->target_h);
      }
    }
  }

  /**
   * Computes target size for height
   */
  private function handleHeight()
  {
    if (is_null($this->getHeight()))
    {
      return;
    }

    $this->target_h = $this->getHeight();
    if (!$this->getInflate() && $this->target_h > $this->source_h)
    {
      $this->target_h = $this->source_h;
    }

    if ($this->getProportional() && $this->source_h > 0)
    {
      // Compute the new width in order to keep the aspect ratio
      // and clamp it to the maximum width
      $this->target_w = round(($this->source_w / $this->source_h) * $this->target_h);

      if (null !== $this->getWidth() && $this->getWidth() < $this->target_w && $this->target_w > 0)
      {
        $this->target_w = $this->getWidth();
        $this->target_h = round(($this->source_h / $this->source_w) * $this->target_w);
      }
    }
  }
}
