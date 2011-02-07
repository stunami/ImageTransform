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
use ImageTransform\Transformation;

/**
 * Transformer class.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class Transformer
{
  /**
   * @var array $transformations Transformation instances that are available for callback
   */
  protected $transformations = array();

  /**
   * @var array $stack Program stack of called transformations
   */
  protected $stack = array();

  /**
   * C'tor
   *
   * @param array $transformations Array of Transformation instances available for callback
   */
  public function __construct($transformations = array())
  {
    foreach($transformations as $transformation)
    {
      $this->addTransformation($transformation);
    }
  }

  /**
   * Adds a Transformation to the available callbacks
   *
   * @param \ImageTransform\Transformation $transformation Transformation instance available for callback
   */
  public function addTransformation(Transformation $transformation)
  {
    $methods = get_class_methods($transformation);
    unset($methods['setImage'], $methods['unset']);

    foreach($methods as $method)
    {
      $this->transformations[$method] = $transformation;
    }
  }

  /**
   * Get a list of currently available Transformation callbacks
   *
   * @return array List of currently available Transformation callbacks
   */
  public function getTransformations()
  {
    return $this->transformations;
  }

  /**
   * Get a list of currently called Transformations
   *
   * @return array List of currently called Transformation
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
      $method         = $entry['method'];
      $arguments      = $entry['arguments'];
      $transformation = $this->transformations[$method];

      $transformation->setImage($image);
      call_user_func_array(array($transformation, $method), $arguments);
      $transformation->unsetImage();
    }
  }

  /**
   * Shortcut for \ImageTransform\Transformer::process()
   *
   * @param \ImageTransform\Image $image Image instance to be processed
   */
  public function __invoke(Image $image)
  {
    $this->process($image);
  }

  /**
   * Fetches all calls to the Transformer and puts them on a stack for later processing.
   *
   * @param  string  $method    Name of the method called
   * @param  array   $arguments Arguments passed with the call
   * @return \ImageTransform\Transformer
   */
  public function __call($method, $arguments)
  {
    if (!isset($this->transformations[$method]))
    {
      throw new \BadMethodCallException($method.' is not a valid callback!');
    }

    $this->stack[] = array(
      'method'    => $method,
      'arguments' => $arguments
    );

    return $this;
  }
}
