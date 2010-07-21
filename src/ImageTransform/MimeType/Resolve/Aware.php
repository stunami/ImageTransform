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
 * Interfaces mime detection awareness for files
 *
 * @category   ImageTransform
 * @package    MimeType
 * @subpackage Resolve
 * @author     Jan Schumann <js@schumann-it.com>
 */
interface ImageTransform_MimeType_Resolve_Aware
{
  /**
   * Constructs a new MimeType-Resolve-Aware Item
   *
   * @param string $filepath The filepath (may be empty or non-existent for new files
   * @param string $mime     Set a mime type manually
   */
  public function __construct($filepath = '', $mime = '');

  /**
   * Set a mime detection strategy to be aware of mime detection methods
   *
   * @param  ImageTransform_MimeType_Resolve_Strategy_Interface $strategy A mime detection strategy
   *
   * @return void
   */
  public function setMimeResolveStrategy(ImageTransform_MimeType_Resolve_Strategy_Interface $strategy);

  /**
   * Returns the resolved mime type
   *
   * @param boolean $forceDetection Force mime detection even if already detected
   *
   * @return string
   */
  public function getMimeType($forceDetection = false);

  /**
   * Allows to set the mime-type manually.
   *
   * @param string $mime
   */
  public function setMimeType($mime);

  /**
   * Gets the path of the file including the filename;
   *
   * @return string
   */
  public function getFilepath();

  /**
   * Sets the filepath including the filename
   *
   * @param string  $filepath The filepath including the filename
   * @param boolean $isNew    If the file is a placeholder
   */
  public function setFilepath($filepath, $isNew = false);
}