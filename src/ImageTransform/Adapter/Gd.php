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
 * Adapter implementation for GD-Extension.
 *
 * @category   ImageTransform
 * @package    Adapter
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Adapter_Gd extends ImageTransform_Adapter_Abstract
{
  /**
   * The image resource.
   *
   * @var resource
  */
  protected $holder;

  /*
   * Supported MIME types for this adapter
   * and their associated file extensions
   *
   * @var array
   */
  protected $types = array(
    'image/jpeg' => array('jpeg','jpg'),
    'image/gif' => array('gif'),
    'image/png' => array('png')
  );

  /*
   * List of GD functions used to load specific image types
   *
   * @var array
   */
  protected $loaders = array(
    'image/jpeg' => 'imagecreatefromjpeg',
    'image/jpg' => 'imagecreatefromjpeg',
    'image/gif' => 'imagecreatefromgif',
    'image/png' => 'imagecreatefrompng'
  );

  /*
   * List of GD functions used to create specific image types
   *
   * @var array
   */
  protected $creators = array(
    'image/jpeg' => 'imagejpeg',
    'image/jpg' => 'imagejpeg',
    'image/gif' => 'imagegif',
    'image/png' => 'imagepng'
  );

  /**
   * Initialize the object. Check for GD extension. An exception is thrown if not installed.
   *
   * @throws ImageTransform_Adapter_Exception
   */
  public function __construct()
  {
    // Check that the GD extension is installed and configured
    if (!extension_loaded('gd'))
    {
      $message = 'The image processing library GD is not enabled. See PHP Manual for installation instructions.';
      throw new ImageTransform_Adapter_Exception($message);
    }
  }

  /**
   * Tidy up the image resources
   */
  public function __destruct()
  {
    if ($this->hasHolder())
    {
      imagedestroy($this->getHolder());
    }
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#create()
   */
  public function create($x=1, $y=1)
  {
    $this->setHolder(imagecreatetruecolor($x,$y));
    imagefill($this->holder,0,0,imagecolorallocate($this->getHolder(), 255, 255, 255));
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#load()
   */
  public function load($filename, $mime)
  {
    if (array_key_exists($mime,$this->loaders))
    {
      $this->holder = $this->loaders[$mime]($filename);
      $this->mimeType = $mime;
      $this->setFilename($filename);

      return true;
    }

    $message = 'Cannot load file %s as %s is an unsupported file type.';
    throw new ImageTransform_Adapter_Exception(sprintf($message, $filename, $mime));
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#loadString()
   */
  public function loadString($string)
  {
    $resource = imagecreatefromstring($string);

    if (is_resource($resource) && 'gd' === get_resource_type($resource))
    {
      $this->setHolder($resource);

      return true;
    }

    return false;
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#__toString()
   */
  public function __toString()
  {
    ob_start();
    $this->__output(false);

    return ob_get_clean();
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#save()
   */
  public function save()
  {
    $this->__output(true);

    return true;
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#saveAs()
   */
  public function saveAs($filename, $mime='')
  {
    if ('' !== $mime)
    {
      if (!$this->setMimeType($mime))
      {
        throw new ImageTransform_Adapter_Exception(sprintf('Cannot convert as %s is an unsupported type' ,$mime));
      }
    }

    $this->setFilename($filename);

    return $this->__output(true, $filename);
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#copy()
   */
  public function copy()
  {
    $copyObj = clone $this;

    $copy = $this->getTransparentImage($this->getWidth(), $this->getHeight());
    imagecopy($copy, $this->getHolder(), 0, 0, 0, 0, $this->getWidth(), $this->getHeight());

    $copyObj->setHolder($copy);

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
      return imagesx($this->getHolder());
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
      return imagesy($this->getHolder());
    }

    return 0;
  }

  /**
   * (non-PHPdoc)
   * @see Guj/Image/Adapter/ImageTransform_Adapter_Interface#setHolder()
   */
  public function setHolder($resource)
  {
    if (is_resource($resource) && 'gd' === get_resource_type($resource))
    {
      $this->holder = $resource;

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
    if (is_resource($this->holder) && 'gd' === get_resource_type($this->holder))
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
    if (array_key_exists($mime,$this->loaders))
    {
      $this->mimeType = $mime;
      return true;
    }

    return false;
  }

  /**
   * Returns image MIME type
   * @return boolean
   *
   */
  public function getMIMETypeFromFilename($filename)
  {
    $path = pathinfo($filename);

    foreach ($this->types as $type => $extensions)
    {
      if (in_array($path['extension'], $extensions))
      {
        return $type;
      }

    }

    return false;
  }

  /**
   * Returns the name of the adapter
   * @return string
   *
   */
  public function getAdapterName()
  {
    return 'Gd';
  }

  /**
   * Returns the image color for a hex value (format #XXXXXX).
   *
   * @param resource image resource
   * @param string full hex value of the color or GD constant
   * @return integer
   */
  public function getColorByHex($image, $color)
  {
    if (preg_match('/#[\d\w]{6}/',$color))
    {
      $rgb = sscanf($color, '#%2x%2x%2x');
      $color = imagecolorallocate($image, $rgb[0], $rgb[1], $rgb[2]);

      return $color;
    }

    return $color;
  }

  /**
   * Returns image in current format and optionally writes image to disk
   * @return resource
   *
   * @throws ImageTransform_Adapter_Exception
   */
  protected function __output($to_file=false, $filename='')
  {
    $file = null;

    // Are we saving to file, if so get the filename to save to
    if ($to_file)
    {
      $file = $filename;
      if ('' === $file)
      {
        $file = $this->getFilename();
      }
    }

    $mime = $this->getMimeType();

    if (array_key_exists($mime,$this->creators))
    {

      switch ($mime)
      {

        case 'image/jpeg':
        case 'image/jpg':
          if (is_null($this->quality))
          {
            $this->quality = 75;
          }
          $output = $this->creators[$mime]($this->holder,$file,$this->getImageSpecificQuality($this->quality, $mime));
          break;

        case 'image/png':
          imagesavealpha($this->holder, true);
          $method = $this->creators[$mime];
          $output = $method($this->holder,$file,$this->getImageSpecificQuality($this->quality, $mime), null);
          break;

        case 'image/gif':

          if (!is_null($file))
          {
            $output = $this->creators[$mime]($this->holder,$file);
          }
          else
          {
            $output = $this->creators[$mime]($this->holder);
          }
          break;

        default:
          throw new ImageTransform_Adapter_Exception(sprintf('Cannot convert as %s is an unsupported type' ,$mime));
      }
    }
    else
    {
      throw new ImageTransform_Adapter_Exception(sprintf('Cannot convert as %s is an unsupported type' ,$mime));
    }

    return $output;
  }

  protected function getImageSpecificQuality($quality, $mime)
  {
    // Range is from 0-100

    if ('image/png' === $mime)
    {

      return 9 - round($quality * (9/100));
    }

    return $quality;
  }

  /**
   * Helper method. Returns a transparent image resource of the specified size
   * @param integer width
   * @param integer height
   * @return resource image
   *
   * @throws ImageTransform_Adapter_Exception
   */
  public function getTransparentImage($w, $h)
  {
    $resource = $this->getHolder();

    $dest_resource = imagecreatetruecolor((int)$w, (int)$h);

    // Preserve alpha transparency
    if (in_array($this->getMIMEType(), array('image/gif','image/png')))
    {
      $index = imagecolortransparent($resource);

      // Handle transparency
      if ($index >= 0)
      {

        // Grab the current images transparent color
        $index_color = imagecolorsforindex($resource, $index);

        // Set the transparent color for the resized version of the image
        $index = imagecolorallocate($dest_resource, $index_color['red'], $index_color['green'], $index_color['blue']);

        // Fill the entire image with our transparent color
        imagefill($dest_resource, 0, 0, $index);

        // Set the filled background color to be transparent
        imagecolortransparent($dest_resource, $index);
      }
      else if ($this->getMIMEType() == 'image/png') // Always make a transparent background color for PNGs that don't have one allocated already
      {

        // Disabled blending
        imagealphablending($dest_resource, false);

        // Grab our alpha tranparency color
        $color = imagecolorallocatealpha($dest_resource, 0, 0, 0, 127);

        // Fill the entire image with our transparent color
        imagefill($dest_resource, 0, 0, $color);

        // Re-enable transparency blending
        imagesavealpha($dest_resource, true);
      }
    }

    return $dest_resource;

  }

}
