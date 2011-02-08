<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform;

use ImageTransform\Image;

/**
 * Transformation class.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class Transformation
{
  /**
   * @var array $transformations transformations that are available for callback
   * @static
   */
  protected static $transformations = array();

  /**
   * @var array $stack Program stack of called transformations
   */
  protected $stack = array();

  /**
   * Get a list of currently called transformations
   *
   * @return array List of currently called transformation
   */
  public function getStack()
  {
    return $this->stack;
  }

  /**
   * Process the stack of transformation on the given Image instance
   *
   * @param \ImageTransform\Image $image Image instance to be processed
   */
  public function process(\ImageTransform\Image $image)
  {
    foreach ($this->stack as $entry)
    {
      extract($entry);

      array_unshift($arguments, $image);

      $image = call_user_func_array($callback, $arguments);
    }
  }

  /**
   * Shortcut for \ImageTransform\Transformation::process()
   *
   * @param \ImageTransform\Image $image Image instance to be processed
   */
  public function __invoke(Image $image)
  {
    $this->process($image);
  }

  /**
   * Fetches all calls to the Transformation and puts them on a stack for later processing.
   *
   * @param  string  $method    Name of the method called
   * @param  array   $arguments Arguments passed with the call
   * @return \ImageTransform\Transformation
   */
  public function __call($method, $arguments)
  {
    try
    {
      $this->stack[] = array(
        'callback'  => static::getTransformation($method),
        'arguments' => $arguments
      );
    }
    catch(\OutOfBoundsException $e)
    {
      throw new \BadMethodCallException($method.' is not a valid callback!');
    }

    return $this;
  }

  /**
   * Adds a transformation to the available callbacks
   *
   * @static
   *
   * @param object $transformation transformation available for callback
   */
  public static function addTransformation($transformation)
  {
    $methods = get_class_methods($transformation);
    unset($methods['setImage'], $methods['unset']);

    foreach($methods as $method)
    {
      self::$transformations[$method] = $transformation;
    }
  }

  /**
   * Get a list of currently available transformation callbacks
   *
   * @static
   *
   * @return array List of currently available transformation callbacks
   */
  public static function getTransformation($method)
  {
    if (!isset(self::$transformations[$method]))
    {
      throw new \OutOfBoundsException('No transformation registered for "'.$method.'"');
    }

    return array(self::$transformations[$method], $method);
  }
}
