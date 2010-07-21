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
 * @subpackage Resolve_Strategy
 * @version    SVN: $Id$
 */

/**
 *
 * Exif mime detection strategy
 *
 * @category   ImageTransform
 * @package    MimeType
 * @subpackage Resolve_Strategy
 * @author     Christian Schaefer <caefer@ical.ly>
 * @author     Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_MimeType_Resolve_Strategy_Exif implements ImageTransform_MimeType_Resolve_Strategy_Interface
{
  public function __construct()
  {
    if (!function_exists('exif_imagetype'))
    {
      throw new ImageTransform_MimeType_Resolve_Strategy_Exception('Exif extension is not loaded');
    }
  }

  /**
   * (non-PHPdoc)
   * @see ImageTransform/MimeType/Resolve/Strategy/Interface#resolve()
   */
  public function resolve($filepath)
  {
    return image_type_to_mime_type(exif_imagetype($filepath));
  }
}
