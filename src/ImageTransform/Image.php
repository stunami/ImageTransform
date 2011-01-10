<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform;

require_once __DIR__.'/../vendor/Symfony/Component/HttpFoundation/UniversalClassLoader.php';

use Symfony\Component\HttpFoundation\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespace('ImageTransform', __DIR__.'/..');
$loader->register();

use ImageTransform\Image\Exception\DelegateNotFoundException;

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
   * @var array $attributes Key / value store to be used for meta information by delegates.
   */
  protected $attributes = array(
    'core.callback_classes' => array()
  );

  /**
   * C'tor
   *
   * @param array $classNames List of Delegate inheriting classes providing transformations.
   */
  public function __construct($classNames = array())
  {
    $callbackClasses = array();
    foreach($classNames as $className)
    {
      $callbackClasses[$className] = get_class_methods($className);
    }
    $this->set('core.callback_classes', $callbackClasses);
  }

  /**
   * Delegation mechanism.
   *
   * Fetches all calls to Image instances and forwards them to the appropriate Delegate.
   *
   * @param  string $method    Name of the method called
   * @param  array  $arguments Arguments passed with the call
   * @return Image             To prevent the fluent API Delegates must always returnan Image instance
   */
  public function __call($method, $arguments)
  {
    foreach ($this->get('core.callback_classes', array()) as $className => $callbacks)
    {
      if (in_array($method, $callbacks))
      {
        $delegate = new $className($this);
        return call_user_func_array(array($delegate, $method), $arguments);
      }
    }

    throw new DelegateNotFoundException();
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
   *
   * @param  string $key   Name of the attribute to set
   * @param  array  $value Value to be set
   */
  public function set($key, $value)
  {
    $this->attributes[$key] = $value;
  }
}
