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
 * Gd mime detection strategy
 *
 * @category   ImageTransform
 * @package    MimeType
 * @subpackage Resolve_Strategy
 * @author     Christian Schaefer <caefer@ical.ly>
 * @author     Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_MimeType_Resolve_Strategy_Gd implements ImageTransform_MimeType_Resolve_Strategy_Interface
{
  public function __construct()
  {
    if (!extension_loaded('gd'))
    {
      throw new ImageTransform_MimeType_Resolve_Strategy_Exception('Gd extension is not loaded');
    }
  }

  /**
   * (non-PHPdoc)
   * @see ImageTransform/MimeType/Resolve/Strategy/Interface#resolve()
   */
  public function resolve($filepath)
  {
    $metaData = getimagesize($filepath);

    if (array_key_exists('mime', $metaData))
    {
      return $metaData['mime'];
    }

    return false;
  }
}
