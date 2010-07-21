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
 * Mock mime detection strategy
 *
 * @category   ImageTransform
 * @package    MimeType
 * @subpackage Resolve_Strategy
 * @author     Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_MimeType_Resolve_Strategy_Mock implements ImageTransform_MimeType_Resolve_Strategy_Interface
{
  private $return;

  public function __construct($return = false)
  {
    $this->return = $return;
  }

  /**
   * Mocks resolve and return mime
   *
   * @param  string $filepath Absolute path to the file of which to detect the mime type
   *
   * @return string|boolean   The resolved mime type or boolean false
   */
  public function resolve($filepath)
  {
    return $this->return;
  }
}