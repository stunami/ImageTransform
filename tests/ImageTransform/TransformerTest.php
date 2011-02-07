<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Tests;

use ImageTransform\Transformer;
use ImageTransform\Image;

class TransformerTest extends \PHPUnit_Framework_TestCase
{
  public function testNewTransformation()
  {
    $transformer = new Transformer(array());
    $this->assertInstanceOf('\ImageTransform\Transformer', $transformer);
    $this->assertEmpty($transformer->getTransformations());
  }

  public function testNewTransformationConfigured()
  {
    $stubTransformation = $this->getMock('\Object', array('dummyCallback'));

    $transformer = new Transformer(array($stubTransformation));

    $this->assertArrayHasKey('dummyCallback', $transformer->getTransformations());

    return $transformer;
  }

  /**
   * @depends testNewTransformationConfigured
   */
  public function testSuccessfulDelegation($transformer)
  {
    $this->assertEquals(0, count($transformer->getStack()));
    $transformer->dummyCallback();
    $this->assertEquals(1, count($transformer->getStack()));
    $transformer->dummyCallback();
    $this->assertEquals(2, count($transformer->getStack()));

    return $transformer;
  }

  /**
   * @depends testNewTransformationConfigured
   * @expectedException \BadMethodCallException
   */
  public function testFailedDelegation($transformer)
  {
    $transformer->nonExistentCallback();
  }

  /**
   * @depends testSuccessfulDelegation
   */
  public function testSuccessfulProcessing($transformer)
  {
    $image = $this->getMock('\ImageTransform\Image', array('create', 'open', 'flush', 'save', 'saveAs'));
    $transformer->process($image);
  }

  /**
   * @depends testSuccessfulDelegation
   */
  public function testSuccessfulProcessingByDirectInvokation($transformer)
  {
    $image = $this->getMock('\ImageTransform\Image', array('create', 'open', 'flush', 'save', 'saveAs'));
    $transformer($image);
  }
}
