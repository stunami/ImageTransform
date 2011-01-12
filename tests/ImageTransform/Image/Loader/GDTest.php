<?php

namespace ImageTransform\Tests\Image\Loader;

use ImageTransform\Image;
use ImageTransform\Image\Loader\GD as Loader;

class GDTest extends \PHPUnit_Framework_TestCase
{
  public function testNewLoader()
  {
    $image = new Image(array('\ImageTransform\Image\Loader\GD'));
    $loader = new Loader($image);
    $this->assertInstanceOf('ImageTransform\Image\Loader\GD', $loader);
    $this->assertEquals('GD', $image->get('core.image_api'));

    return $loader;
  }

  /**
   * @depends testNewLoader
   */
  public function testCreation($loader)
  {
    $width = 80;
    $height = 100;

    $image = $loader->create($width, $height);

    $this->assertInternalType('resource', $image->get('image.resource'));
    $this->assertFalse($image->get('image.mimeType'));
    $this->assertEquals($width, $image->get('image.width'));
    $this->assertEquals($height, $image->get('image.height'));
  }

  /**
   * @depends testNewLoader
   */
  public function testLoadingFromFile($loader)
  {
    $filepath = __DIR__.'/../../../fixtures/20x20-pattern.jpg';

    $image = $loader->open($filepath);

    $this->assertInternalType('resource', $image->get('image.resource'));
    $this->assertEquals('image/jpeg', $image->get('image.mime_type'));
    $this->assertEquals(20, $image->get('image.width'));
    $this->assertEquals(20, $image->get('image.height'));
  }

  /**
   * @depends testNewLoader
   * @expectedException InvalidArgumentException
   */
  public function testLoadingFromNonExistingFile($loader)
  {
    $loader->open('/this/image/does/not/exist.jpg');
  }

  /**
   * @depends testNewLoader
   * @expectedException \ImageTransform\Image\Exception\MimeTypeNotSupportedException
   */
  public function testLoadingFromFileOfWrongMimeType($loader)
  {
    $loader->open(__FILE__);
  }
}
