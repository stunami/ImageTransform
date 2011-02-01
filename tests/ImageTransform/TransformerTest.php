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
    $this->assertEmpty($transformer->get('core.callback_classes'));
  }

  public function testNewTransformationConfigured()
  {
    $stubTransformation = $this->getMock('Transformation', array('dummyCallback'));
    $stubTransformationClassName = get_class($stubTransformation);

    $transformer = new Transformer(array($stubTransformationClassName));

    $this->assertArrayHasKey($stubTransformationClassName, $transformer->get('core.callback_classes'));

    return $transformer;
  }

  /**
   * @depends testNewTransformationConfigured
   */
  public function testSuccessfulDelegation($transformer)
  {
    $this->assertEquals(0, count($transformer->get('core.program_stack')));
    $transformer->dummyCallback();
    $this->assertEquals(1, count($transformer->get('core.program_stack')));
    $transformer->dummyCallback();
    $this->assertEquals(2, count($transformer->get('core.program_stack')));

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
    $image = new Image();
    $transformer->process($image);
  }

  /**
   * @depends testSuccessfulDelegation
   */
  public function testSuccessfulProcessingByDirectInvokation($transformer)
  {
    $image = new Image();
    $transformer($image);
  }

  /**
   * @depends testSuccessfulDelegation
   */
  public function testSuccessfulProcessingImageFromWidthAndHeight($transformer)
  {
    $stubTransformation = $this->getMock('Transformation', array('create'));
    $stubTransformationClassName = get_class($stubTransformation);

    $transformer = new Transformer(array($stubTransformationClassName));
    $image = new Image();
    $image->set('source.width', 20);
    $image->set('source.height', 20);
    $transformer->process($image);
  }

  public function testAttributeAccess()
  {
    $transformer = new Transformer(array());
    $this->assertFalse($transformer->get('test.value'));
    $transformer->set('test.value', 'barfoo');
    $this->assertEquals('barfoo', $transformer->get('test.value'));
  }
}
