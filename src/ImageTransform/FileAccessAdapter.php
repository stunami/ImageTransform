<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform;

/**
 * Interface defining file access for image resources
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
interface FileAccessAdapter
{
  /**
   * Create an image resource
   *
   * @param integer              $width  Width of the image to be created
   * @param integer              $height Height of the image to be created
   */
  public function create($width, $height);

  /**
   * Open a resource for an Image
   *
   * @param string               $filepath Location of the file to open
   */
  public function open($filepath);

  /**
   * Flush an Image resource to stdout
   *
   * @param string               $mimeType Mime type of the target file
   */
  public function flush($mimeType = false);

  /**
   * Save an Image resource under its current location
   */
  public function save();

  /**
   * Save an Image resource under a given filepath
   *
   * @param string               $filepath Locastion where to save the resource
   * @param string               $mimeType Mime type of the target file
   */
  public function saveAs($filepath, $mimeType = false);
}
