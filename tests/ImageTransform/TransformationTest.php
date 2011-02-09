<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Tests;

use ImageTransform\Transformation;
use ImageTransform\Image;

class TransformationTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @expectedException \OutOfBoundsException
   * @covers \ImageTransform\Transformation::getTransformation
   */
  public function testUnaddedTransformation()
  {
    $methodName = 'dummyCallback';
    Transformation::getTransformation($methodName);
  }

  /**
   * @depends testUnaddedTransformation
   * @covers \ImageTransform\Transformation::addTransformation
   * @covers \ImageTransform\Transformation::getTransformation
   */
  public function testAddingTransformation()
  {
    $methodName = 'dummyCallback';
    $stubTransformation = $this->getMock('\Object', array($methodName));

    Transformation::addTransformation($stubTransformation);

    $callback = Transformation::getTransformation($methodName);
    $this->assertInternalType('array', $callback);
    $this->assertEquals($stubTransformation, $callback[0]);
    $this->assertEquals($methodName, $callback[1]);
  }

  /**
   * @covers \ImageTransform\Transformation::__call
   * @covers \ImageTransform\Transformation::getStack
   */
  public function testSuccessfulDelegation()
  {
    $methodName = 'dummyCallback';
    $stubTransformation = $this->getMock('\Object', array($methodName));

    Transformation::addTransformation($stubTransformation);

    $transformation = new Transformation();

    $this->assertEquals(0, count($transformation->getStack()));
    $transformation->dummyCallback();
    $this->assertEquals(1, count($transformation->getStack()));
    $transformation->dummyCallback();
    $this->assertEquals(2, count($transformation->getStack()));

    return $transformation;
  }

  /**
   * @depends testUnaddedTransformation
   * @expectedException \BadMethodCallException
   * @covers \ImageTransform\Transformation::__call
   */
  public function testFailedDelegation($transformation)
  {
    $methodName = 'dummyCallback';
    $transformation = new Transformation();
    $transformation->$methodName();
  }

  /**
   * @depends testSuccessfulDelegation
   * @covers \ImageTransform\Transformation::process
   */
  public function testSuccessfulProcessing($transformation)
  {
    $image = $this->getMock('\ImageTransform\Image', array('create', 'open', 'flush', 'save', 'saveAs', 'initialize'));
    $transformation->process($image);
  }

  /**
   * @covers \ImageTransform\Transformation::__invoke
   */
  public function testSuccessfulProcessingByDirectInvokation()
  {
    $image = $this->getMock('\ImageTransform\Image', array('create', 'open', 'flush', 'save', 'saveAs', 'initialize'));
    $transformation = $this->getMock('\ImageTransform\Transformation', array('process'));
    $transformation->expects($this->once())->method('process')->with($this->equalTo($image));

    $transformation($image);
  }
}
