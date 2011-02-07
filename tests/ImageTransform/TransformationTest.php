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
  public function testNewTransformation()
  {
    $transformation = new Transformation(array());
    $this->assertInstanceOf('\ImageTransform\Transformation', $transformation);
    $this->assertEmpty($transformation->getTransformations());
  }

  public function testNewTransformationConfigured()
  {
    $stubTransformation = $this->getMock('\Object', array('dummyCallback'));

    $transformation = new Transformation(array($stubTransformation));

    $this->assertArrayHasKey('dummyCallback', $transformation->getTransformations());

    return $transformation;
  }

  /**
   * @depends testNewTransformationConfigured
   */
  public function testSuccessfulDelegation($transformation)
  {
    $this->assertEquals(0, count($transformation->getStack()));
    $transformation->dummyCallback();
    $this->assertEquals(1, count($transformation->getStack()));
    $transformation->dummyCallback();
    $this->assertEquals(2, count($transformation->getStack()));

    return $transformation;
  }

  /**
   * @depends testNewTransformationConfigured
   * @expectedException \BadMethodCallException
   */
  public function testFailedDelegation($transformation)
  {
    $transformation->nonExistentCallback();
  }

  /**
   * @depends testSuccessfulDelegation
   */
  public function testSuccessfulProcessing($transformation)
  {
    $image = $this->getMock('\ImageTransform\Image', array('create', 'open', 'flush', 'save', 'saveAs'));
    $transformation->process($image);
  }

  /**
   * @depends testSuccessfulDelegation
   */
  public function testSuccessfulProcessingByDirectInvokation($transformation)
  {
    $image = $this->getMock('\ImageTransform\Image', array('create', 'open', 'flush', 'save', 'saveAs'));
    $transformation($image);
  }
}
