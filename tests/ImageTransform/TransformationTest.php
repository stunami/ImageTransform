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
    $this->assertEmpty($transformation->get('core.callback_classes'));
  }

  public function testNewTransformationConfigured()
  {
    $stubDelegate = $this->getMock('Delegate', array('dummyCallback'));
    $stubDelegateClassName = get_class($stubDelegate);

    $transformation = new Transformation(array($stubDelegateClassName));

    $this->assertArrayHasKey($stubDelegateClassName, $transformation->get('core.callback_classes'));

    return $transformation;
  }

  /**
   * @depends testNewTransformationConfigured
   */
  public function testSuccessfulDelegation($transformation)
  {
    $this->assertEquals(0, count($transformation->get('core.program_stack')));
    $transformation->dummyCallback();
    $this->assertEquals(1, count($transformation->get('core.program_stack')));
    $transformation->dummyCallback();
    $this->assertEquals(2, count($transformation->get('core.program_stack')));

    return $transformation;
  }

  /**
   * @depends testNewTransformationConfigured
   * @expectedException ImageTransform\Image\Exception\DelegateNotFoundException
   */
  public function testFailedDelegation($transformation)
  {
    $transformation->nonExistentCallback();
  }

  /**
   * @depends testSuccessfulDelegation
   * @expectedException ImageTransform\Image\Exception\NoImageResourceException
   */
  public function testFailedProcessing($transformation)
  {
    $transformation->process(new Image());
  }

  /**
   * @depends testSuccessfulDelegation
   */
  public function testSuccessfulProcessingByInvoking($transformation)
  {
    $stubDelegate = $this->getMock('Delegate', array('open'));
    $stubDelegateClassName = get_class($stubDelegate);
    $stubDelegateClassName = 'ImageTransform\Image\Loader\GD';

    $transformation = new Transformation(array($stubDelegateClassName));
    $image = new Image(__DIR__.'/../fixtures/20x20-pattern.jpg');
    $this->assertEquals(0, count($transformation->get('core.program_stack')));
    $transformation($image);
    $this->assertEquals(1, count($transformation->get('core.program_stack')));
  }

  /**
   * @depends testSuccessfulDelegation
   */
  public function testSuccessfulProcessingImageFromFilepath($transformation)
  {
    $stubDelegate = $this->getMock('Delegate', array('open'));
    $stubDelegateClassName = get_class($stubDelegate);
    $stubDelegateClassName = 'ImageTransform\Image\Loader\GD';

    $transformation = new Transformation(array($stubDelegateClassName));
    $image = new Image(__DIR__.'/../fixtures/20x20-pattern.jpg');
    $this->assertEquals(0, count($transformation->get('core.program_stack')));
    $transformation->process($image);
    $this->assertEquals(1, count($transformation->get('core.program_stack')));
  }

  /**
   * @depends testSuccessfulDelegation
   */
  public function testSuccessfulProcessingImageFromWidthAndHeight($transformation)
  {
    $stubDelegate = $this->getMock('Delegate', array('open'));
    $stubDelegateClassName = get_class($stubDelegate);
    $stubDelegateClassName = 'ImageTransform\Image\Loader\GD';

    $transformation = new Transformation(array($stubDelegateClassName));
    $image = new Image();
    $image->set('source.width', 20);
    $image->set('source.height', 20);
    $transformation->process($image);
  }

  public function testAttributeAccess()
  {
    $transformation = new Transformation(array());
    $this->assertFalse($transformation->get('test.value'));
    $transformation->set('test.value', 'barfoo');
    $this->assertEquals('barfoo', $transformation->get('test.value'));
  }
}
