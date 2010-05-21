<?php
/**
 * This file is part of the ImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @category   ImageTransform
 * @version    $Id:$
 */

/**
 * ImageTransform Autoloader
 *
 * @category   ImageTransform
 *
 * @author Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_Autoloader
{
  protected $prefix = 'ImageTransform_';
  protected $dir;

  private function __construct()
  {
    $this->dir = realpath(dirname(__FILE__) . '../../');
  }

  /**
   * Instanciates the autoloader and registers it via spl_autoload_register.
   */
  public static function register()
  {
    $loader = new self();
    spl_autoload_register(array ($loader, 'autoload'));
  }

  /**
   * @param string $class The name of the class
   */
  public function autoload($class)
  {
    if (0 === strpos($class, $this->prefix))
    {
      $file = $this->dir . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
      if (file_exists($file))
      {
        require $file;
      }

      return;
    }
  }
}