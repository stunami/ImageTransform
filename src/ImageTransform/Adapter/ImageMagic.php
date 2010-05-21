<?php
/**
 * This file is part of the ImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @category   ImageTransform
 * @package    Adapter
 * @version    $Id:$
 */

/**
 * Adapter implementation for iMagic-Extension.
 *
 * @category   ImageTransform
 * @package    Adapter
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Adapter_ImageMagic extends ImageTransform_Adapter_Abstract
{
  /**
   * The image resource.
   * @access protected
   * @var resource
   *
   * @throws sfImageTransformException
  */
  protected $holder;

  /*
   * Supported MIME types for the sfImageImageMagickAdapter
   * and their associated file extensions
   * @var array
   */
  protected $types = array(
    'image/jpeg' => array('jpeg','jpg'),
    'image/gif' => array('gif'),
    'image/png' => array('png')
  );

  /**
   * Initialize the object. Check for imagick extension. An exception is thrown if not installed
   *
   * @throws sfImageTransformException
   */
  public function __construct()
  {
    // Check that the GD extension is installed and configured
    if (!extension_loaded('imagick'))
    {
      $message = 'The image processing library ImageMagick is not enabled. ';
      $message .= 'See PHP Manual for installation instructions.';
      throw new ImageTransform_Adapter_Exception($message);
    }

    $this->setHolder(new Imagick());
  }

  /**
   * Tidy up the object
  */
  public function __destruct()
  {
    if ($this->hasHolder())
    {
      $this->getHolder()->destroy();
    }
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#create()
   */
  public function create($x=1, $y=1)
  {
    $image = new Imagick();
    $image->newImage($x, $y, new ImagickPixel('white'));
    $image->setImageFormat('png');
    $this->setHolder($image);
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#load()
   */
  public function load($filepath, $mime)
  {
    if (preg_match('/image\/.+/',$mime))
    {
      $this->holder = new Imagick($filepath);
      $this->mimeType = $mime;
      $this->setFilename($filepath);

      return true;
    }

    $message = 'Cannot load file %s as %s is an unsupported file type.';
    throw new ImageTransform_Adapter_Exception(sprintf($message, $filepath, $mime));
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#loadString()
   */
  public function loadString($string)
  {
    return $this->getHolder()->readImageBlob($string);
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#__toString()
   */
  public function __toString()
  {
    $this->getHolder()->setImageCompressionQuality($this->getQuality());

    return (string)$this->getHolder();
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#save()
   */
  public function save()
  {
    $this->getHolder()->setImageCompressionQuality($this->getQuality());

    return $this->getHolder()->writeImage($this->getFilename());
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#saveAs()
   */
  public function saveAs($filepath, $mime='')
  {
    if ('' !== $mime)
    {
      $this->setMimeType($mime);
    }

    $this->getHolder()->setImageCompressionQuality($this->getQuality());

    return $this->getHolder()->writeImage($filepath);
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#copy()
   */
  public function copy()
  {
    $copyObj = clone $this;

    $copyObj->setHolder($this->getHolder()->clone());

    return $copyObj;
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#getWidth()
   */
  public function getWidth()
  {
    if ($this->hasHolder())
    {
      return $this->getHolder()->getImageWidth();
    }

    return 0;
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#getHeight()
   */
  public function getHeight()
  {
    if ($this->hasHolder())
    {
      return $this->getHolder()->getImageHeight();
    }

    return 0;
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#setHolder()
   */
  public function setHolder($holder)
  {
    if (is_object($holder) && 'Imagick' === get_class($holder))
    {
      $this->holder = $holder;
      return true;
    }

    return false;
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#getHolder()
   */
  public function getHolder()
  {
    if ($this->hasHolder())
    {
      return $this->holder;
    }

    return false;
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#hasHolder()
   */
  public function hasHolder()
  {
    if (is_object($this->holder) && 'Imagick' === get_class($this->holder))
    {
      return true;
    }

    return false;
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#getMimeType()
   */
  public function getMimeType()
  {
    return $this->mimeType;
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#setMimeType()
   */
  public function setMimeType($mime)
  {
    $this->mimeType = $mime;
    if ($this->hasHolder() && isset($this->types[$mime]))
    {
      $this->getHolder()->setImageFormat($this->types[$mime][0]);

      return true;
    }

    return false;
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#getAdapterName()
   */
  public function getAdapterName()
  {
    return 'ImageMagick';
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#setQuality()
   */
  public function setQuality($quality)
  {
    if (parent::setQuality($quality))
    {
      $this->getHolder()->setImageCompressionQuality($quality);

      return true;
    }

    return false;
  }

}