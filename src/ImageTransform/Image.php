<?php

namespace ImageTransform;

require_once __DIR__.'/../vendor/Symfony/Component/HttpFoundation/UniversalClassLoader.php';

use Symfony\Component\HttpFoundation\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespace('ImageTransform', __DIR__.'/..');
$loader->register();

use ImageTransform\Image\Exception\DelegateNotFoundException;

class Image
{
  protected $attributes = array(
    'core.callback_classes' => array()
  );

  public function __construct($classNames = array())
  {
    $callbackClasses = array();
    foreach($classNames as $className)
    {
      $callbackClasses[$className] = get_class_methods($className);
    }
    $this->set('core.callback_classes', $callbackClasses);
  }

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

  public function get($key, $default = false)
  {
    return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : $default;
  }

  public function set($key, $value)
  {
    $this->attributes[$key] = $value;
  }
}
