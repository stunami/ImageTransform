<?php
/**
 * This file is part of the ImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @category   ImageTransform
 * @package    MimeType
 * @subpackage Resolve
 * @version    SVN: $Id$
 */

/**
 * Represents a file and its mime type
 *
 * @category   ImageTransform
 * @package    File
 * @author     Stuart Lowes <stuart.lowes@gmail.com>
 * @author     Jan Schumann <js@schumann-it.com>
 */
final class ImageTransform_Source
{
  /**
   * An ImageTransform Adapter
   *
   * @var ImageTransform_Adapter_Interface
   */
  private $adapter;

  /*
   * MIME type map and their associated file extension(s)
   * @var array
   *
   * @todo move to seperate class
   */
  private $types = array(
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
  private $defaultImage = array(
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
   * @param ImageTransform_Adapter_Interface      An Adapter instance
   * @param ImageTransform_MimeType_Resolve_Aware An object that provides MimeDetection
   */
  public function __construct(ImageTransform_Adapter_Interface $adapter, ImageTransform_File $file = null)
  {
    $this->setAdapter($adapter);

    if (is_null($file) || !$file->exists())
    {
      $this->create();
    }
    else
    {
      $this->load($file);
    }
  }

  /**
   * Sets the image library adapter object
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
   * Returns the image resource
   * Convenience method for $i->getAdapter()->getHolder()
   *
   * @return resource
   */
  public function getResource()
  {
    return $this->getAdapter()->getHolder();
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
   * @throws ImageTransform_Source_Exception
   *
   * @param ImageTransform_File The image file
   *
   * @return ImageTransform_Source
   */
  public function load(ImageTransform_File $file)
  {
    $this->getAdapter()->load($file->getFilepath(), $file->getMimeType());

    return $this;
  }

  /**
   * Loads image from a string
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
   * @param boolean $transform Indicated weather to transfom before save.
   *
   * @return boolean
   */
  public function save($transform = true)
  {
    if (true === $transform)
    {
      $this->transform();
    }

    if (false === $this->getAdapter()->save())
    {
      throw new ImageTransform_Source_Exception('The Imgage could not be saved');
    }

    return true;
  }

  /**
   * Saves the image to the specified filename
   *
   * @throws ImageTransform_Source_Exception
   *
   * @param  ImageTransform_File The image file
   *
   * @return ImageTransform_Source
   */
  public function saveAs(ImageTransform_File $file)
  {
    $copy = $this->copy();

    $copy->transform();

    $copy->getAdapter()->saveAs($file->getFilepath(), $file->getMimeType());

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
   * Copies the image object and returns it
   *
   * Returns a copy of the ImageTransform_Source object
   *
   * @return ImageTransform_Source
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
   * Add a Transform to the queue
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
      'adapterName' => '' === $adapterName ? $this->getAdapter()->getAdapterName() : $adapterName
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