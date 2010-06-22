<?php
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Abstract test case implementation for the ImageTransform package.
 *
 * @category  ImageTransform
 * @package   Test
 * @author    Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_AbstractTest extends PHPUnit_Framework_TestCase
{
  private $fixturesPath;

  /**
   * Removes temporary test contents.
   *
   * @return void
   */
  protected function setUp()
  {
    parent::setUp();

    $run = dirname(__FILE__) . '/_run';
    if (file_exists($run) === false)
    {
      mkdir($run, 0755);
    }

    $this->clearRunResources($run);

    $this->fixturesPath = realpath(dirname(__FILE__) . '/../../fixtures');

    require_once dirname(__FILE__) . '/../../../src/ImageTransform/bootstrap.php';
  }

  /**
   * Removes temporary test contents.
   *
   * @return void
   */
  protected function tearDown()
  {
    $this->clearRunResources();

    parent::tearDown();
  }

  /**
   * Clears all temporary resources.
   *
   * @param string $dir The root directory.
   *
   * @return void
   */
  private function clearRunResources($dir = null)
  {
    if ($dir === null)
    {
      $dir = dirname(__FILE__) . '/_run';
    }

    foreach (new DirectoryIterator($dir) as $file)
    {
      if ($file == '.' || $file == '..' || $file == '.svn')
      {
        continue;
      }
      $pathName = realpath($file->getPathname());
      if ($file->isDir())
      {
        $this->_clearRunResources($pathName);
        rmdir($pathName);
      }
      else
      {
        unlink($pathName);
      }
    }
  }

  protected function getFixturesPath()
  {
    return $this->fixturesPath;
  }

  protected function getImageFixturesPath($adapterName = 'Gd')
  {
    return $this->getFixturesPath() . '/images/' . $adapterName;
  }

  /**
   * Creates a temporary resource for the given file name.
   *
   * @param string $fileName The temporary file name.
   *
   * @return string
   */
  protected static function createRunResourceURI($fileName)
  {
    $uri = dirname(__FILE__) . '/_run/' . $fileName;
    if (file_exists($uri) === true)
    {
      throw new ErrorException("File '{$fileName}' already exists.");
    }
    return $uri;
  }

  protected function createAdapter($name = '')
  {
    return ImageTransform_Adapter_Factory::createAdapter($name);
  }
}