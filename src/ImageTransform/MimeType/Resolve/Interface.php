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
 * Interfaces mime detection awareness
 *
 * @category   ImageTransform
 * @package    MimeType
 * @subpackage Resolve
 * @author     Jan Schumann <js@schumann-it.com>
 */
interface ImageTransform_MimeType_Resolve_Aware
{
  public function setMimeResolveStrategy();
}