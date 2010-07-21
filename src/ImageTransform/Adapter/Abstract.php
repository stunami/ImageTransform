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
 * Base abstract class for ImageTransform_Adapter implementations.
 *
 * @category   ImageTransform
 * @package    Adapter
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
abstract class ImageTransform_Adapter_Abstract implements ImageTransform_Adapter_Interface
{
  /**
   * Image filename including the full path
   *
   * @var string
   */
  protected $filepath = 'Untitled.png';

  /**
   * Default ouput mime type.
   *
   * @var string
   */
  protected $mimeType = 'image/png';

  /**
   * Quality.
   *
   * @var integer
   */
  protected $quality = null;

  /**
   * (non-PHPdoc)
   * @see ImageTransform/Adapter/ImageTransform_Adapter_Interface#setFilename()
   */
  public function setFilename($filepath)
  {
    if ('' !== $filepath)
    {
      $this->filepath = $filepath;

      return true;
    }

    return false;

  }

  /**
   * (non-PHPdoc)
   * @see ImageTransform/Adapter/ImageTransform_Adapter_Interface#getFilename()
   */
  public function getFilename()
  {
    return $this->filepath;
  }

  /**
   * (non-PHPdoc)
   * @see ImageTransform/Adapter/ImageTransform_Adapter_Interface#setQuality()
   */
  public function setQuality($quality)
  {
    if (is_numeric($quality) && $quality >= 0 && $quality <= 100)
    {
      $this->quality = $quality;

      return true;
    }

    return false;
  }

  /**
   * (non-PHPdoc)
   * @see ImageTransform/Adapter/ImageTransform_Adapter_Interface#getQuality()
   */
  public function getQuality()
  {
    return $this->quality;
  }
}
