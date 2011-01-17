<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Tests\Transformation;

use ImageTransform\Image;
use ImageTransform\Transformation\Loader;

class LoaderTest extends \PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->image = new Image();
    $this->loader = $this->getMock('\ImageTransform\Transformation\Loader', array('doCreate', 'doOpen'), array($this->image));
  }

  public function testNewLoader()
  {
    $this->assertInstanceOf('ImageTransform\Transformation\Loader', $this->loader);
  }

  public function testCreation()
  {
    $this->loader->create(10, 20);
    $this->assertInstanceOf('ImageTransform\Image', $this->image);
  }

  public function testLoadingFromFile()
  {
    $filepath = '/tmp/image.jpg';

    $this->loader->open($filepath);
    $this->assertInstanceOf('ImageTransform\Image', $this->image);
    $this->assertEquals($filepath, $this->image->get('image.filepath'));
  }
}
