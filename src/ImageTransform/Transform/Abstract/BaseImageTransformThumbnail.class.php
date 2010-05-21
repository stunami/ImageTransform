<?php
/*
 * This file is part of the sfImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * sfImageThumbnailGeneric class
 *
 * generic thumbnail transform
 *
 * Create a thumbnail 100 x 100, with the image resized to fit
 * <code>
 * <?php
 * $img = new sfImage('image1.jpg');
 * $img->thumbnail(100, 100);
 * $img->setQuality(50);
 * $img->saveAs('thumbnail.png');
 * ?>
 * </code>
 *
 * @package sfImageTransform
 * @subpackage transforms
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Miloslav Kmet <miloslav.kmet@gmail.com>
 * @version SVN: $Id$
 */
class BaseImageTransformThumbnail extends BaseImageTransform
{
  /**
   * width of the thumbnail
   */
  protected $width;

  /**
   * height of the thumbnail
   */
  protected $height;

  /**
   * method to be used for thumbnail creation. default is scale.
   */
  protected $method = 'fit';

  /**
   * available methods for thumbnail creation
   */
  protected $methods = array('fit', 'scale', 'inflate','deflate', 'left' ,'right', 'top', 'bottom', 'center');

  /*
   * background color in hex or null for transparent
   */
  protected $background = null;

  /**
   * constructor
   *
   * @param integer $width of the thumbnail
   * @param integer $height of the thumbnail
   * @param string type of thumbnail method to be created
   *
   * @return void
   */
  public function __construct($width, $height, $method='fit', $background=null)
  {
    if(!$this->setWidth($width) || !$this->setHeight($height))
		{
			throw new sfImageTransformException(sprintf('Cannot perform thumbnail, a valid width and height must be supplied'));
		}
    $this->setMethod($method);
    $this->setBackground($background);
  }

  /**
   * sets the height of the thumbnail
   * @param integer $height of the image
   *
   * @return void
   */
  public function setHeight($height)
  {
    if(is_numeric($height) && $height > 0)
    {
      $this->height = (int)$height;

      return true;
    }

    return false;
  }

  /**
   * returns the height of the thumbnail
   *
   * @return integer
   */
  public function getHeight()
  {
    return $this->height;
  }

  /**
   * sets the width of the thumbnail
   * @param integer $width of the image
   *
   * @return void
   */
  public function setWidth($width)
  {
    if(is_numeric($width) && $width > 0)
    {
      $this->width = (int)$width;

      return true;
    }

    return false;
  }

  /**
   * returns the width of the thumbnail
   *
   * @return integer
   */
  public function getWidth()
  {
    return $this->width;
  }

  /**
   * returns the width of the thumbnail
   * @param string thumbnail method. Options are scale (default), deflate (or inflate), right, left, top, bottom, scale
   *
   * @return integer
   */
  public function setMethod($method)
  {

    if(in_array($method, $this->methods))
    {
      $this->method = strtolower($method);

      return true;
    }

    return false;
  }

  /**
   * returns the method for thumbnail creation
   *
   * @return integer
   */
  public function getMethod()
  {
    return $this->method;
  }

  /**
   * Sets background color.
   *
   * @param string
   */
  public function setBackground($color)
  {
    $this->background = $color;
  }

  /**
   * Gets background color.
   *
   * @return string
   */
  public function getBackground()
  {
    return $this->background;
  }

  /**
   * Apply the transformation to the image and returns the image thumbnail
   */
  protected function transform(sfImage $image)
  {
    return $image;
  }
}
