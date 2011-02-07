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
 * Image class.
 *
 * Instances represent a single image providing a fluent interface of transformations to execute.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
abstract class Image
{
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
      $this->open($filepath);
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
}
