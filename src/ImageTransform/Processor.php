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
use ImageTransform\Processor\ProcessorInterface;

/**
 * Transformation class.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
abstract class Processor implements ProcessorInterface
{
  /**
   * @var array $transformations transformations that are available for callback
   */
  protected $transformations = array();
  
  /**
   *
   * @var array $instances instances of transformations
   */
  protected $instances = array();

  /**
   * @var array $stack Program stack of called transformations
   */
  protected $stack = array();
  
  /**
   * Returns whether the transform implements the correct image library interface
   * 
   * @param string $class transformation class
   * @return boolean returns true if valid transform class else false
   */
  abstract function isValidClass($class);  
  
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
  public function process(Image $image)
  {
    foreach ($this->stack as $entry)
    {
      $method = $entry['method'];
      $arguments = $entry['arguments'];

      array_unshift($arguments, $image);
      
      $callback = $this->getTransformationCallback($method);

      call_user_func_array($callback, $arguments);
    }
  }

  /**
   * Shortcut for \ImageTransform\Transformation::applyTo()
   *
   * @param \ImageTransform\Image $image Image instance to be processed
   */
  public function __invoke(Image $image)
  {
    $this->applyTo($image);
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
    if (!isset($this->transformations[$method]))
    {
      $message = sprintf('No transformation registered for "%s"', $method);
      throw new \OutOfBoundsException($message);
    }
    
    $this->stack[] = array(
      'method'    => $method,
      'arguments' => $arguments
    );
   
    return $this;
  }

  /**
   * Adds a transformation to the available callbacks
   *
   * @param string $method method on callback class
   * @param string $class the callback class
   * @param string $alias an alias to be used instead of the callback method
   */
  public function addTransformation($method, $class, $alias = null)
  {
    if (!\is_callable(array($class, $method)) || !$this->isValidClass($class, $method))
    {
      $message = sprintf('%s::%s is not a valid callback!', $class, $method);
      throw new \BadMethodCallException($message);
    }
        
    $name = $method;
    if (!empty($alias) && preg_match('/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*./', $name))
    {
      $name = $alias;
    }

    $this->transformations[$name] = array('method' => $method, 'class' => $class);
  }
  
  /**
   * Allows adding of many transformation definitions
   * 
   * @param array $transformations An array of tranform callbacks definitions with keys, method, class, alias (optional)
   */
  public function addTransformations(array $transformations)
  {
    foreach ($transformations as $transformation)
    {      
      $alias = false;
      
      if (
        isset($transformation['method']) && !empty($transformation['method']) &&
        isset($transformation['class']) && !empty($transformation['class'])
      )
      {
        if (isset($transformation['alias']) && !empty($transformation['alias']))
        {
          $alias = $transformation['alias'];
        }
               
        $this->addTransformation($transformation['method'], $transformation['class'], $alias);        
      }
      
      else
      {
        throw new \BadMethodCallException('Both method and class must be provided');
      }     
    }
  }

  /**
   * Gets the transformation callbacks for the specified method
   *
   * @return array List of currently available transformation callbacks
   */
  public function getTransformation($method)
  {
    if (!isset($this->transformations[$method]))
    {
      throw new \OutOfBoundsException('No transformation registered for "'.$method.'"');
    }

    return $this->transformations[$method];
  }
  
  protected function getTransformationInstance($method)
  {
    if (!isset($this->instances[$method]))
    {
      $this->instances[$method] = new $this->transformations[$method]['class'];
    }
    
    return $this->instances[$method];
  }
  
  protected function getTransformationCallback($method)
  {
    return array($this->getTransformationInstance($method), $this->transformations[$method]['method']);
  }
}
