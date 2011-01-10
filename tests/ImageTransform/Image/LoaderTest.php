<?php

namespace ImageTransform\Tests;

use ImageTransform\Image;
use ImageTransform\Image\Loader;

class LoaderTest extends \PHPUnit_Framework_TestCase
{
  public function testNewLoader()
  {
    $loader = $this->getMock('\ImageTransform\Image\Loader', array('createImage', 'loadImage'), array(new Image()));
    $this->assertInstanceOf('ImageTransform\Image\Loader', $loader);

    return $loader;
  }

  /**
   * @depends testNewLoader
   */
  public function testCreation($loader)
  {
    $image = $loader->create(10, 20);
    $this->assertInstanceOf('ImageTransform\Image', $image);
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
