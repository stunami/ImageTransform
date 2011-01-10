<?php

namespace ImageTransform\Tests;

use ImageTransform\Image;
use ImageTransform\Image\Loader;

class LoaderTest extends \PHPUnit_Framework_TestCase
{
  public function testNewLoader()
  {
    $loader = new Loader(new Image());
    $this->assertInstanceOf('ImageTransform\Image\Loader', $loader);

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
    $this->assertInstanceOf('ImageTransform\Image', $image);
    $this->assertEquals($width, $image->get('image.width'));
    $this->assertEquals($height, $image->get('image.height'));
  }

  /**
   * @depends testNewLoader
   */
  public function testLoadingFromFile($loader)
  {
    $filepath = '/tmp/image.jpg';

    $image = $loader->from($filepath);
    $this->assertInstanceOf('ImageTransform\Image', $image);
    $this->assertEquals($filepath, $image->get('image.filepath'));
  }
}
