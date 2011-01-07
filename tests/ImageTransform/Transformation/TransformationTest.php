<?php

namespace ImageTransform\Tests\Transformation;

require_once __DIR__.'/../../../src/ImageTransform/Transformation/Transformation.php';

use ImageTransform\Image;
use ImageTransform\Transformation\Transformation;
use Symfony\Component\EventDispatcher\EventDispatcher;

class TransformationTest extends \PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->mock = $this->getMock('\ImageTransform\Transformation\Transformation', array('doNothing'));
    $dispatcher = new EventDispatcher();
    $dispatcher->connect(Image::EVENT_TRANSFORMATION, array($this->mock, 'execute'));
    $this->image = new Image($dispatcher);
  }

  public function testExecutionOfExistingMethod()
  {
    $this->mock->expects($this->once())->method('doNothing')->will($this->returnValue(true));
    $this->assertTrue($this->image->doNothing());
  }

  /**
   * @expectedException ImageTransform\Transformation\Exception\TransformationNotFoundException
   */
  public function testExecutionOfNotExistingMethod()
  {
    $this->mock->expects($this->never())->method('doesnotexist');
    $this->image->doSomething();
  }
}
