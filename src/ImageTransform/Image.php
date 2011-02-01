<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform;

use ImageTransform\FileAccessAdapter;

/**
 * Image class.
 *
 * Instances represent a single image providing a fluent interface of transformations to execute.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class Image
{
  /**
   * @var ImageTransform\FileAccessAdapter $adapter
   */
  protected static $adapter;

  /**
   * @var array $attributes Key / value store to be used for meta information by delegates.
   */
  protected $attributes = array();

  /**
   * C'tor
   *
   * @param array $classNames List of Delegate inheriting classes providing transformations.
   */
  public function __construct($filepath = false)
  {
    if(false !== $filepath)
    {
      $this->open($this, $filepath);
    }
  }

  /**
   * Attribute accessor.
   *
   * @param  string $key     Name of the attribute to return
   * @param  array  $default Default value in case the key is unknown
   * @return mixed           The value as stored in $this->attributes[$key] or the $default
   */
  public function get($key, $default = false)
  {
    return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : $default;
  }

  /**
   * Attribute mutator.
   w
   *
   * @param string $key   Name of the attribute to set
   * @param array  $value Value to be set
   */
  public function set($key, $value)
  {
    $this->attributes[$key] = $value;
  }

  /**
   * Dispatches calls to self::$adapter
   *
   * @param  string $method Name of method called
   * @param  array  $arguments Arguments passed to this call
   * @return ImageTransform\Image
   */
  public function __call($method, $arguments)
  {
    if(!(self::$adapter instanceof \ImageTransform\FileAccessAdapter))
    {
      throw new \BadMethodCallException($method.'() can not be called as no adapter is set!');
    }

    if(!is_callable(array(self::$adapter, $method)))
    {
      throw new \BadMethodCallException($method.'() is not implemented!');
    }

    call_user_func_array(array(self::$adapter, $method), $arguments);

    return $this;
  }

  /**
   * Registers adapter for file access
   *
   * @param ImageTransform\FileAccessAdapter $adapter Instance implementing ImageTransform\FileAccessAdapter interface
   */
  public static function setFileAccessAdapter(\ImageTransform\FileAccessAdapter $adapter)
  {
    self::$adapter = $adapter;
  }
}
