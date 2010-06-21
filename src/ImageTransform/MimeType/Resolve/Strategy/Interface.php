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
 *
 * mime detection strategy interface
 *
 * @category   ImageTransform
 * @package    MimeType
 * @subpackage Resolve_Strategy
 * @author     Christian Schaefer <caefer@ical.ly>
 * @author     Jan Schumann <js@schumann-it.com>
 */
interface ImageTransform_MimeType_Resolve_Strategy_Interface
{
  /**
   * Resolve and return mime type of given filepath
   *
   * @param  string $filepath Absolute path to the file of which to detect the mime type
   * @return string|boolean   The resolved mime type or boolean false
   */
  public function resolve($filepath);
}