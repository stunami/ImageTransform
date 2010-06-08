<?php
/**
 * This file is part of the ImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @category   ImageTransform
 * @package    Transform
 * @version    $Id:$
 */

/**
 * A factory for Image  Transform Transformations
 *
 * @category   ImageTransform
 * @package    Transform
 *
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Transform_Factory
{
  /**
   * @param string $adapterName The adapter to create the transform class with.
   *                            If the class cannot be found. The generic class will be used.
   * @param string $method      The transform method
   * @param mixed  $arg(1-n)    Any Arguments for the transform class constructor
   *
   * @throws ImageTransform_Transform_Exception
   */
  public static function create($adapterName, $method)
  {
    $funcArgs = func_get_args();
    $argCount = func_num_args();
    $arguments = array();
    for ($i = 2; $i < $argCount; $i++)
    {
      $arguments[] = $funcArgs[$i];
    }

    return self::createWithArgumentsArray($adapterName, $method, $arguments);
  }

  /**
   * @param string $adapterName The adapter to create the transform class with.
   *                            If the class cannot be found. The generic class will be used.
   * @param string $method      The transform method
   * @param array  $arguments   Arguments for the transform class constructor
   *
   * @throws Guj_Image_Transforms_Exception
   */
  public static function createWithArgumentsArray($adapterName, $method, $arguments)
  {
    $class_generic = 'ImageTransform_Transform_Generic_' . ucfirst($method);
    $class_adapter = 'ImageTransform_Transform_' . ucfirst($adapterName) . '_' . ucfirst($method);

    // Make sure a transform class exists, either generic or adapter specific, otherwise throw an exception

    // @TODO implement class loading by Zend_Loader::loadClass() ??
    if (class_exists($class_adapter,true))
    {
      // Defaults to adapter transform
      $class = $class_adapter;
    }
    elseif (class_exists($class_generic,true))
    {
      // No adapter specific transform so look for a generic transform
      $class = $class_generic;
    }
    else
    {
      $message = 'Unsupported transform %s. Cannot find %s adapter or generic transform class.';
      throw new ImageTransform_Transform_Exception(sprintf($message, $method, $adapterName));
    }

    $reflectionObj = new ReflectionClass($class);
    if (is_array($arguments) && count($arguments) > 0)
    {
      $transform = $reflectionObj->newInstanceArgs($arguments);
    }
    else
    {
      $transform = $reflectionObj->newInstance();
    }

    return $transform;
  }

}