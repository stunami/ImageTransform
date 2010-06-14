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
 * Create a thumbnail 100 x 100, with the image resized to fit
 * <code>
 * <?php
 * $img = new ImageTransform_Source('image1.jpg');
 * $img->thumbnail(100, 100);
 * $img->setQuality(50);
 * $img->saveAs('thumbnail.png');
 * ?>
 * </code>
 *
 * @category   ImageTransform
 * @package    Transform
 * @subpackage Generic
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Miloslav Kmet <miloslav.kmet@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_Generic_Thumbnail extends ImageTransform_Transform_Abstract_Thumbnail
{
  /**
   * @var int
   */
  private $resource_w;
  /**
   * @var int
   */
  private $resource_h;

  /**
   * @var float
   */
  private $scale_w;
  /**
   * @var float
   */
  private $scale_h;

  /**
   * Apply the transformation to the image and returns the image thumbnail
   *
   * @param ImageTransform_Source
   * @return ImageTransform_Source
   */
  protected function transform()
  {
    $this->resource_w = $this->getImage()->getWidth();
    $this->resource_h = $this->getImage()->getHeight();

    $this->scale_w    = $this->getWidth() / $this->resource_w;
    $this->scale_h    = $this->getHeight() / $this->resource_h;

    $method = $this->getMethod();

    if (false === method_exists($this, $method))
    {
      $method = 'fit';
    }

    return $this->$method();

  }

  private function inflate()
  {
    return $this->deflate();
  }

  private function deflate()
  {
    return $this->getImage()->resize($this->getWidth(), $this->getHeight());
  }

  private function left()
  {
    $this->getImage()->scale(max($this->scale_w, $this->scale_h));
    $top = (int) round(($this->getImage()->getHeight() - $this->getHeight()) / 2);
    return $this->getImage()->crop(0, $top, $this->getWidth(), $this->getHeight());
  }

  private function right()
  {
    $this->getImage()->scale(max($this->scale_w, $this->scale_h));
    $left = $this->getImage()->getWidth() - $this->getWidth();
    $top = (int) round(($this->getImage()->getHeight() - $this->getHeight()) / 2);
    return $this->getImage()->crop($left, $top, $this->getWidth(), $this->getHeight());
  }

  private function top()
  {
    $this->getImage()->scale(max($this->scale_w, $this->scale_h));
    $left = (int) round(($this->getImage()->getWidth() - $this->getWidth()) / 2);
    return $this->getImage()->crop($left, 0, $this->getWidth(), $this->getHeight());
  }

  private function bottom()
  {
    $this->getImage()->scale(max($this->scale_w, $this->scale_h));
    $left = (int) round(($this->getImage()->getWidth() - $this->getWidth()) / 2);
    $top = $this->getImage()->getHeight() - $this->getHeight();
    return $this->getImage()->crop($left, $top, $this->getWidth(), $this->getHeight());
  }

  private function center()
  {
    $this->getImage()->scale(max($this->scale_w, $this->scale_h));
    $left = (int) round(($this->getImage()->getWidth() - $this->getWidth()) / 2);
    $top  = (int) round(($this->getImage()->getHeight() - $this->getHeight()) / 2);
    return $this->getImage()->crop($left, $top, $this->getWidth(), $this->getHeight());
  }

  private function scale()
  {
    return $this->getImage()->scale(min($this->scale_w, $this->scale_h));
  }

  private function fit()
  {
    $img = clone $this->getImage();
    $this->getImage()->create($this->getWidth(), $this->getHeight());

    // Set a background color if specified
    if (!is_null($this->getBackground()) && $this->getBackground() != '')
    {
      $this->getImage()->fill(0,0, $this->getBackground());
    }

    $img->scale(min($this->getWidth() / $img->getWidth(), $this->getHeight() / $img->getHeight()));
    return $this->getImage()->overlay($img, 'center');
  }
}
