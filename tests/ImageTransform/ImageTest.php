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

class ImageTest extends \PHPUnit_Framework_TestCase
{
  public function testNewImage()
  {
    $image = new Image();
    $this->assertInstanceOf('ImageTransform\Image', $image);
  }

  public function testNewImagePassingFilepath()
  {
    $filepath = __DIR__.'/../fixtures/20x20-pattern.jpg';

    $image = new Image($filepath);

    $this->assertInstanceOf('ImageTransform\Image', $image);
    $this->assertEquals($filepath, $image->get('source.filepath'));
  }

  public function testAttributeAccess()
  {
    $image = new Image();
    $this->assertFalse($image->get('test.value'));
    $image->set('test.value', 'barfoo');
    $this->assertEquals('barfoo', $image->get('test.value'));
  }
}
