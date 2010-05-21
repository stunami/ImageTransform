<?php
/**
 * This file is part of the ImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @category   ImageTransform
 * @package    Source
 * @version    $Id:$
 */

/**
 * ImageTransform Source class
 *
 * A container class for the image resource.
 *
 * This class allows the manipulation using classes that implement ImageTransform_Transform_Interface
 *
 * Example 1 Chaining
 *
 * <code>
 * <?php
 * $img = new sfImage('image1.jpg', 'image/png', 'GD');
 * $response = $this->getResponse();
 * $response->setContentType($img->getMIMEType());
 * $response->setContent($img->resize(1000,null)->overlay(sfImage('logo.png','','')));
 * ?>
 * </code>
 *
 * Example 2 Standalone
 * <code>

 * $img = new sfImage('image1.jpg', 'image/jpg', 'ImageMagick');
 * $t = new sfImageScale(0.5);
 * $img = $t->execute($img);
 * $img->save('image2.jpg', 'image/jpg');
 * </code>
 *
 * @category   ImageTransform
 * @package    Source
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Source
{
  /**
   * An ImageTransform Adapter
   *
   * @var ImageTransform_Adapter_Interface
   */
  protected $adapter;

  /*
   * MIME type map and their associated file extension(s)
   * @var array
   *
   * @todo move to seperate class
   */
  protected $types = array(
    'image/gif' => array('gif'),
    'image/jpeg' => array('jpg', 'jpeg'),
    'image/png' => array('png'),
    'image/svg' => array('svg'),
    'image/tiff' => array('tiff')
  );

  /**
   * Default Image params
   * @todo move to config class
   * @var array
   */
  protected $defaultImage = array(
    'filename' => 'Untitled.png',
    'mime_type' => 'image/png',
    'width' => 100,
    'height' => 100
  );

  /**
   * An array of transforms to be executed
   *
   * @var array
   */
  private $transforms = array();

  /**
   * @var integer
   */
  private $transformCount = 0;

  /**
   * @var boolean
   */
  private $isExecuting = false;

  /**
   * Constructs a new ImageTransform_Source object
   *
   * @access public
   *
   * @param ImageTransform_Adapter_Interface An Adapter instance
   * @param string Filepath of the image to be loaded
   * @param string File MIME type
   */
  public function __construct(ImageTransform_Adapter_Interface $adapter, $filepath = '', $mime = '')
  {
    $this->setAdapter($adapter);

    if ('' === $filepath)
    {
      $this->create();
    }
    else
    {
      $this->load($filepath, $mime);
    }
  }


  /**
   * Sets the image library adapter object
   *
   * @access public
   *
   * @param ImageTransform_Adapter_Interface
   */
  public function setAdapter(ImageTransform_Adapter_Interface $adapter)
  {
    $this->adapter = $adapter;
  }

  /**
   * Gets the image library adapter object
   *
   * @access public
   *
   * @param ImageTransform_Adapter_Interface
   */
  public function getAdapter()
  {
    return $this->adapter;
  }

  /**
   * Creates a blank image (Defaults are loaded by $this->defaultImage @todo move configuration to seperate class)
   *
   * @access public
   *
   * @param integer Width of image
   * @param integer Height of image
   * @param string Backfground color of image
   */
  public function create($x=null, $y=null, $color=null)
  {
    // Get default width
    if (!is_numeric($x))
    {
      $x = 1;
      if (isset($this->defaultImage['width']))
      {
        $x = (int)$this->defaultImage['width'];
      }
    }

    // Get default height
    if (!is_numeric($y))
    {
      $y = 1;
      if (isset($this->defaultImage['height']))
      {
        $y = (int)$this->defaultImage['height'];
      }
    }

    $this->getAdapter()->create($x, $y);
    $this->getAdapter()->setFilename($this->defaultImage['filename']);

    // Set the image color if set
    if (is_null($color))
    {
      $color = '#FFFFFF';

      if (isset($this->defaultImage['color']))
      {
        $color = $this->defaultImage['color'];
      }
    }

    $this->fill(0, 0, $color);

    return $this;
  }

  /**
   * Loads image from disk
   *
   * Loads an image of specified MIME type from the filesystem
   *
   * @access public
   *
   * @throws ImageTransform_Source_Exception
   *
   * @param string Path of image file
   * @param string MIME type of image
   *
   * @return ImageTransform_Source
   */
  public function load($filepath, $mime = '')
  {
    if (file_exists($filepath))
    {

      if ('' == $mime)
      {
        $mime = $this->autoDetectMIMETypeFromFile($filepath);
      }

      if ('' == $mime)
      {
        $message = 'You must either specify the MIME type for file %s or enable mime detection';
        throw new ImageTransform_Source_Exception(sprintf($message, $filepath));
      }

      $this->getAdapter()->load($filepath, $mime);

      return $this;
    }

    $message = 'Unable to load %s. File does not exist or is unreadable';
    throw new ImageTransform_Source_Exception(sprintf($message, $filepath));
  }

  /**
   * Loads image from a string
   *
   * @access public
   *
   * @param string Image string
   *
   * @return ImageTransform_Source
   */
  public function loadString($string)
  {
    $this->getAdapter()->loadString($string);

    return $this;
  }

  /**
   * Saves the image to disk
   *
   * Saves the image to the filesystem
   *
   * @access public
   *
   * @param string
   *
   * @return boolean
   */
  public function save()
  {
    $this->transform();
    return $this->getAdapter()->save();
  }

  /**
   * Saves the image to the specified filename
   *
   * Allows the saving to a different filename
   *
   * @access public
   *
   * @throws ImageTransform_Source_Exception
   *
   * @param string Path of image file
   * @param string MIME type of image
   *
   * @return ImageTransform_Source
   */
  public function saveAs($filepath, $mime = '')
  {
    if ('' === $mime)
    {
      $mime = $this->autoDetectMIMETypeFromFilename($filepath);
    }

    if (!$mime)
    {
      throw new ImageTransform_Source_Exception(sprintf('Unsupported file %s', $filepath));
    }

    $this->transform();

    $copy = $this->copy();

    $copy->getAdapter()->saveAs($filepath, $mime);

    return $copy;
  }

  /**
   * Copies the image object and returns it
   *
   * Returns a copy of the sfImage object
   *
   * @access public
   *
   * @return ImageTransform_Source
   */
  public function copy()
  {
    $copy = clone $this;
    $copy->resetTransforms();
    $copy->setAdapter($this->getAdapter()->copy());

    return $copy;
  }

  /**
   * Returns the image as a string
   *
   * @access public
   *
   * @return string
   */
  public function __toString()
  {
    return $this->toString();
  }

  /**
   * Converts the image to a string
   *
   * Returns the image as a string
   *
   * @access public
   *
   * @return string
   */
  public function toString()
  {
    return (string)$this->getAdapter();
  }

  /**
   * Magic method. Will return this instance to make chaining possible.
   *
   * Each __call will add the requested transform to the queue. Please call execute() to execute the transforms.
   *
   * @param string $method
   * @param array $arguments
   */
  public function __call($method, $arguments)
  {
    // Execute the transform immediately if we are currently executing transforms
    if ($this->isExecuting())
    {
      $this->doTransform($method, $arguments);
    }
    else
    {
      $this->addTransform($method, $arguments);
    }

    // So we can chain transforms return the reference to itself
    return $this;
  }

  /**
   * Sets the image filename
   *
   * @param string
   *
   * @return boolean
   */
  public function setFilename($filename)
  {
    return $this->getAdapter()->setFilename($filename);
  }

  /**
   * Returns the image full filename
   * @return string The filename of the image
   *
   */
  public function getFilename()
  {
    return $this->getAdapter()->getFilename();
  }

  /**
   * Returns the image pixel width
   * @return integer
   *
   */
  public function getWidth()
  {
    return $this->getAdapter()->getWidth();
  }

  /**
   * Returns the image height
   * @return integer
   *
   */
  public function getHeight()
  {
    return $this->getAdapter()->getHeight();
  }

  /**
   * Sets the MIME type
   * @param string
   *
   */
  public function setMIMEType($mime)
  {
    $this->getAdapter()->setMIMEType($mime);
  }

  /**
   * Returns the MIME type
   * @return string
   *
   */
  public function getMIMEType()
  {
    return $this->getAdapter()->getMIMEType();
  }

  /**
   * Sets the image quality
   * @param integer Valid range is from 0 (worst) to 100 (best)
   *
   */
  public function setQuality($quality)
  {
    $this->getAdapter()->setQuality($quality);
  }

  /**
   * Returns the image quality
   * @return string
   *
   */
  public function getQuality()
  {
    return $this->getAdapter()->getQuality();
  }

  /**
   * Returns mime type from the specified file type. Returns false for unsupported types
   * @access protected
   * @return string or boolean
   */
  protected function autoDetectMIMETypeFromFilename($filename)
  {
    $pathinfo = pathinfo($filename);

    foreach ($this->types as $mime => $extension)
    {
      if (in_array(strtolower($pathinfo['extension']),$extension))
      {
        return $mime;
      }

    }

    return false;
  }

  /**
   * Returns mime type from the actual file using a detection library
   * @TODO implement autodetection in seperate class
   * @access protected
   * @return string or boolean
   */
  protected function autoDetectMIMETypeFromFile($filename)
  {
    $settings = array(); //sfConfig::get('app_sfImageTransformPlugin_mime_type','GD');

    $support_libraries = array('fileinfo', 'mime_type', 'gd_mime_type');

    if (false === $settings['auto_detect'])
    {
      return false;
    }

    if (in_array(strtolower($settings['library']), $support_libraries) && '' !== $filename)
    {
      if ('gd_mime_type' === strtolower($settings['library']))
      {
        if (!extension_loaded('gd'))
        {
          throw new Exception ('GD not enabled. Cannot detect mime type using GD.');
        }

        $imgData = GetImageSize($filename);

        if (isset($imgData['mime']))
        {
          return $imgData['mime'];
        }

        else
        {
          return false;
        }
      }

      if ('fileinfo' === strtolower($settings["library"]))
      {

        if (function_exists('finfo_file'))
        {
          $finfo = finfo_open(FILEINFO_MIME);

          return finfo_file($finfo, $filename);
        }
      }

      if ('mime_type' === strtolower($settings["library"]))
      {
        // Supressing warning as PEAR is not strict compliant
        @require_once 'MIME/Type.php';
        if (method_exists('MIME_Type', 'autoDetect'))
        {
          return @MIME_Type::autoDetect($filename);
        }
      }
    }

    return false;
  }

  /**
   * Copies the image object and returns it
   *
   * Returns a copy of the sfImage object
   *
   * @return sfImage
   */
  public function __clone()
  {
    $this->adapter = $this->adapter->copy();
  }

  /**
   * Set the transformations handled by this instance.
   *
   * @param array $transforms
   */
  public function setTransforms(array $transforms)
  {
    foreach ($transforms as $transform)
    {
      $adapterName = isset($transform['adapterName']) ? $transform['adapterName'] : '';

      $this->addTransform($transform['method'], $transform['arguments'], $adapterName);
    }
  }

  /**
   * Add a tranform to the queue
   *
   * @param string $method
   * @param array $arguments
   * @param string $adapterName
   */
  public function addTransform($method, array $arguments, $adapterName = '')
  {
    $this->transforms[] = array(
      'method' => $method,
      'arguments' => $arguments,
      'adapterName' => empty($adapterName) ? $this->imageAdapterName : $adapterName
    );
  }

  /**
   * Returns weather the containing image was transformed
   *
   * @return boolean
   */
  public function isTransformed()
  {
    return 0 < $this->getTransformCount();
  }

  /**
   * Returns the num of transformations executed on the containing image
   *
   * @return integer
   */
  public function getTransformCount()
  {
    return $this->transformCount;
  }

  /**
   * Executes all pending transformations
   *
   * @return boolean
   */
  public function transform()
  {
    $this->isExecuting = true;

    foreach ($this->transforms as $item)
    {
      //$this->image->setAdapter(ImageTransform_Adapter_Factory::createAdapter($item['adapterName']));
      $this->doTransform($item['method'], $item['arguments']);
    }

    $this->resetTransforms();

    $this->isExecuting = false;

    return $this;
  }

  /**
   * Reset the transforms
   *
   * @return
   */
  private function resetTransforms()
  {
    $this->transforms = array();

    return $this;
  }

  /**
   * execute a transform on this instance
   *
   * @param string $method
   * @param array $arguments
   */
  private function doTransform($method, array $arguments)
  {
    $adapterName = $this->getAdapter()->getAdapterName();
    $transform = ImageTransform_Transform_Factory::createWithArgumentsArray($adapterName, $method, $arguments);

    $transform->execute($this);
    ++$this->transformCount;

    // Tidy up
    unset($transform);
  }

  public function isExecuting()
  {
    return (bool) $this->isExecuting;
  }


}