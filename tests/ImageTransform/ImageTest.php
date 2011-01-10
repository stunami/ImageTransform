<?php

namespace ImageTransform\Tests;

use ImageTransform\Image;

class ImageTest extends \PHPUnit_Framework_TestCase
{
  public function testNewImage()
  {
    $stubDelegate = $this->getMock('Delegate', array('dummyCallback'));
    $stubDelegateClassName = get_class($stubDelegate);

    $image = new Image(array($stubDelegateClassName));

    $this->assertInstanceOf('ImageTransform\Image', $image);
    $this->assertArrayHasKey($stubDelegateClassName, $image->get('core.callback_classes'));

    return $image;
  }

  /**
   * @depends testNewImage
   */
  public function testAttributeAccess($image)
  {
    $this->assertFalse($image->get('test.value'));
    $image->set('test.value', 'barfoo');
    $this->assertEquals('barfoo', $image->get('test.value'));
  }

  /**
   * @depends testNewImage
   */
  public function testSuccessfulDelegation($image)
  {
    $this->assertNull($image->dummyCallback());
  }

  /**
   * @depends testNewImage
   * @expectedException ImageTransform\Image\Exception\DelegateNotFoundException
   */
  public function testFailedDelegation($image)
  {
    $image->nonExistantCallback();
  }
}
