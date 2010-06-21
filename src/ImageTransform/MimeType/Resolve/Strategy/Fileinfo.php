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
 * Fileinfo mime detection strategy
 *
 * @category   ImageTransform
 * @package    MimeType
 * @subpackage Resolve_Strategy
 * @author     Christian Schaefer <caefer@ical.ly>
 * @author     Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_MimeType_Resolve_Strategy_Fileinfo implements ImageTransform_MimeType_Resolve_Strategy_Interface
{
  public function __construct()
  {
    if (!function_exists('finfo_file'))
    {
      throw new ImageTransform_MimeType_Resolve_Strategy_Exception('Fileinfo extension is not loaded');
    }
  }

  /**
   * Resolve and return mime via finfo_file()
   *
   * @param  string $filepath Absolute path to the file of which to detect the mime type
   *
   * @return string|boolean   The resolved mime type or boolean false
   */
  public function resolve($filepath)
  {
    // Support for PHP 5.3+
    if (defined(FILEINFO_MIME_TYPE))
    {
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
    }
    else
    {
      $finfo = finfo_open(FILEINFO_MIME);
    }

    return finfo_file($finfo, $filepath);
  }
}
