<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Tests;

use ImageTransform\Image;
use ImageTransform\FileAccessAdapter;

class ImageTest extends \PHPUnit_Framework_TestCase
{
  public function testNewImage()
  {
    $image = new Image();
    $this->assertInstanceOf('ImageTransform\Image', $image);
  }

  /**
   * @expectedException BadMethodCallException
   */
  public function testImageCallWithoutAdapter()
  {
    $image = new Image();
    $image->open('/path/to/some/file');
  }

  /**
   * @expectedException BadMethodCallException
   */
  public function testImageCallToNotImplementedMethod()
  {
    $fileAccessAdapter = $this->getMock('\ImageTransform\FileAccessAdapter');

    Image::setFileAccessAdapter($fileAccessAdapter);

    $image = new Image();
    $image->doesnotexist();
  }

  public function testNewImageWithImplicitCallToOpenByPassingAFilepath()
  {
    $filepath = __DIR__.'/../fixtures/20x20-pattern.jpg';

    $fileAccessAdapter = $this->getMock('\ImageTransform\FileAccessAdapter');
    $fileAccessAdapter->expects($this->once())
      ->method('open')
      ->with(
        $this->isInstanceOf('\ImageTransform\Image'),
        $this->equalTo($filepath)
      );

    Image::setFileAccessAdapter($fileAccessAdapter);

    $image = new Image($filepath);

    $this->assertInstanceOf('\ImageTransform\Image', $image);
  }

  public function testCallDelegation()
  {
    $fileAccessAdapter = $this->getMock('\ImageTransform\FileAccessAdapter', array('create', 'open', 'flush', 'save', 'saveAs', 'testMyArguments'));
    $fileAccessAdapter->expects($this->once())
      ->method('testMyArguments')
      ->with(
        $this->isInstanceOf('\ImageTransform\Image'),
        $this->isTrue(),
        $this->isFalse()
      );

    Image::setFileAccessAdapter($fileAccessAdapter);

    $image = new Image();
    $image->testMyArguments(true, false);
  }

  public function testAttributeAccess()
  {
    $image = new Image();
    $this->assertFalse($image->get('test.value'));
    $image->set('test.value', 'barfoo');
    $this->assertEquals('barfoo', $image->get('test.value'));
  }
}
