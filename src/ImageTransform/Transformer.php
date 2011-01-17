<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform;

use \ImageTransform\Transformation\Exception\NoImageResourceException;
use \ImageTransform\Transformation\Exception\TransformationNotFoundException;

/**
 * Transformer class.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class Transformer
{
  /**
   * @var array $attributes Key / value store to be used for meta information by delegates.
   */
  protected $attributes = array(
    'core.callback_classes' => array(),
    'core.program_stack' => array()
  );

  /**
   * C'tor
   *
   * @param array $classNames List of Transformation inheriting classes providing transformations.
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

  public function process(Image $image)
  {
    $this->initImageResource($image);

    foreach($this->attributes['core.program_stack'] as $transformationData)
    {
      $className = $transformationData['className'];
      $method = $transformationData['method'];
      $arguments = $transformationData['arguments'];

      $transformation = new $className($image);
      call_user_func_array(array($transformation, $method), $arguments);
    }
  }

  public function __invoke(Image $image)
  {
    return $this->process($image);
  }

  public function initImageResource($image)
  {
    if(($filepath = $image->get('source.filepath')))
    {
      array_unshift($this->attributes['core.program_stack'], $this->findCallback('open', array($filepath)));
    }
    else if(($width = $image->get('source.width')) && ($height = $image->get('source.height')))
    {
      array_unshift($this->attributes['core.program_stack'], $this->findCallback('create', array($width, $height)));
    }
    else
    {
      throw new NoImageResourceException('Please specify filepath or width/height!');
    }
  }

  /**
   * Delegation mechanism.
   *
   * Fetches all calls to Image instances and forwards them to the appropriate Transformation.
   *
   * @param  string  $method    Name of the method called
   * @param  array   $arguments Arguments passed with the call
   * @return boolean
   */
  public function __call($method, $arguments)
  {
    array_push($this->attributes['core.program_stack'], $this->findCallback($method, $arguments));
    return $this;
  }

  public function findCallback($method, $arguments)
  {
    foreach ($this->get('core.callback_classes', array()) as $className => $callbacks)
    {
      if (in_array($method, $callbacks))
      {
        return array('className' => $className, 'method' => $method, 'arguments' => $arguments);
      }
    }

    throw new TransformationNotFoundException();
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
