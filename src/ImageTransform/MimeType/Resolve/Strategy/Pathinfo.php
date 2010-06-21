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
 * Üathinfo mime detection strategy
 *
 * @category   ImageTransform
 * @package    MimeType
 * @subpackage Resolve_Strategy
 * @author     Christian Schaefer <caefer@ical.ly>
 * @author     Jan Schumann <js@schumann-it.com>
 */
class IImageTransform_MimeType_Resolve_Strategy_Pathinfo implements ImageTransform_MimeType_Resolve_Strategy_Interface
{
  /**
   * (non-PHPdoc)
   * @see ImageTransform/MimeType/Resolve/Strategy/Interface#resolve()
   */
  public function resolve($filepath)
  {
    switch (strtolower(pathinfo($filepath, PATHINFO_EXTENSION)))
    {
      case 'bmp':  return 'image/bmp';
      case 'cod':  return 'image/cis-cod';
      case 'gif':  return 'image/gif';
      case 'ief':  return 'image/ief';
      case 'jpeg':
      case 'jpg':  return 'image/jpeg';
      case 'jfif': return 'image/pipeg';
      case 'tif':  return 'image/tiff';
      case 'ras':  return 'image/x-cmu-raster';
      case 'cmx':  return 'image/x-cmx';
      case 'ico':  return 'image/x-icon';
      case 'pnm':  return 'image/x-portable-anymap';
      case 'pbm':  return 'image/x-portable-bitmap';
      case 'pgm':  return 'image/x-portable-graymap';
      case 'ppm':  return 'image/x-portable-pixmap';
      case 'rgb':  return 'image/x-rgb';
      case 'xbm':  return 'image/x-xbitmap';
      case 'xpm':  return 'image/x-xpixmap';
      case 'xwd':  return 'image/x-xwindowdump';
      case 'png':  return 'image/png';
      case 'jps':  return 'image/x-jps';
      case 'fh':   return 'image/x-freehand';
      default:     return false;
    }
  }
}
