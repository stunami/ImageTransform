<?php
/**
 * This file is part of the ImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @category   ImageTransform
 * @package    Adapter
 * @version    $Id:$
 */

/**
 * An interface description for ImageTransform_Adapter classes.
 *
 * These classes are wrappers for image manipulating librarys or extensions. They implement
 * functions like loading, creating and get metadata.
 *
 * @category   ImageTransform
 * @package    Adapter
 *
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @author Jan Schumann <js@schumann-it.com>
 */
interface ImageTransform_Adapter_Interface
{
  /**
   * Create a new empty image with specified width and height
   *
   * @param integer Width
   * @param integer Height
   */
  function create($x=1, $y=1);

  /**
   * Load and sets the resource from an existing file
   *
   * @param string Can either be a valid filesestem path
   *               or a valid streamWrapper uri
   * @param string The mime-type of the image
   *
   * @return boolean
   */
  function load($filepath, $mime);

  /**
   * Loads an image from a string
   *
   * @param string A binary string representing an image
   *
   * @return boolean
   */
  function loadString($string);

  /**
   * Save the image to disk
   *
   * @return boolean
   */
  function save();

  /**
   * Save the image to disk under a different name
   *
   * @param string
   * @param string
   *
   * @return boolean
   */
  function saveAs($filename, $mime='');

  /**
   * Returns a copy of the adapter object
   *
   * @return ImageTransform_Adapter_Interface
   */
  function copy();

  /**
   * Gets the pixel width of the image
   *
   * @return integer
   */
  function getWidth();

  /**
   * Gets the pixel height of the image
   *
   * @return integer
   */
  function getHeight();

  /**
   * Returns whether there is a valid image resource
   *
   * @return boolean
   */
  function hasHolder();

  /**
   * Returns the image resource
   *
   * @return resource
   */
  function getHolder();

  /**
   * Sets the image resource
   *
   * @param resource An image resource
   *
   * @return boolean
   */
  function setHolder($holder);

  /**
   * Returns the image MIME type
   *
   * @return string
   */
  function getMimeType();

  /**
   * Sets the image MIME type
   *
   * @param string
   *
   * @return boolean
   */
  function setMimeType($mime);

  /**
   * Get the image as string
   *
   * @return string
   */
  function __toString();

  /**
   * Returns the name of the adapter
   *
   * @return string
   */
  function getAdapterName();

  /**
   * Returns the filename including the full path
   *
   * @return string
   */
  function getFilename();

  /**
   * Sets the filename including the full path
   *
   * @param string
   *
   * @return boolean
   */
  function setFilename($filename);

  /**
   * Returns the current setting for the image quality
   *
   * @return integer
   */
  function getQuality();

  /**
   * Sets the setting for the image quality
   *
   * @param integer
   *
   * @return boolean
   */
  function setQuality($quality);
}