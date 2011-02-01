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
   * @param ImageTransform\Image $image  Instance to create a resource for
   * @param integer              $width  Width of the image to be created
   * @param integer              $height Height of the image to be created
   */
  public function create(\ImageTransform\Image $image, $width, $height);

  /**
   * Open a resource for an Image
   *
   * @param ImageTransform\Image $image    Instance to create a resource for
   * @param string               $filepath Location of the file to open
   */
  public function open(\ImageTransform\Image $image, $filepath);

  /**
   * Flush an Image resource to stdout
   *
   * @param ImageTransform\Image $image  Instance to create a resource for
   * @param string               $mimeType Mime type of the target file
   */
  public function flush(\ImageTransform\Image $image, $mimeType = false);

  /**
   * Save an Image resource under its current location
   *
   * @param ImageTransform\Image $image  Instance to create a resource for
   */
  public function save(\ImageTransform\Image $image);

  /**
   * Save an Image resource under a given filepath
   *
   * @param ImageTransform\Image $image    Instance to create a resource for
   * @param string               $filepath Locastion where to save the resource
   * @param string               $mimeType Mime type of the target file
   */
  public function saveAs(\ImageTransform\Image $image, $filepath, $mimeType = false);
}
