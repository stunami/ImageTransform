<?php

namespace ImageTransform\Tests;

require_once __DIR__.'/../../src/ImageTransform/Image.php';

use ImageTransform\Image;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ImageTest extends \PHPUnit_Framework_TestCase
{
  protected $dispatcher, $stub;

  protected function setUp()
  {
    $this->stub = $this->getMock('ImageTestEventListener', array('transformation'));

    $this->dispatcher = new EventDispatcher();
    $this->dispatcher->connect(Image::EVENT_TRANSFORMATION, array($this->stub, 'transformation'));
  }

  public function testNewImage()
  {
    $image = new Image($this->dispatcher);
    $this->assertInstanceOf('ImageTransform\Image', $image);
  }

  public function testCallingTransformation()
  {
    $image = new Image($this->dispatcher);
    $this->stub->expects($this->once())->method('transformation')->will($this->returnCallback(function($event){return 'doesexist' == $event->get('method');}));

    $image->doesexist();
  }

  /**
   * @expectedException ImageTransform\Transformation\Exception\TransformationNotFoundException
   */
  public function testCallingUnknownMethod()
  {
    $image = new Image($this->dispatcher);
    $this->stub->expects($this->once())->method('transformation')->will($this->returnCallback(function($event){return 'doesexist' == $event->get('method');}));

    $image->doesnotexist();
  }
}
