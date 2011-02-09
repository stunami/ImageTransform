<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Tests\Transformation\Resizer;

use ImageTransform\Image;
use ImageTransform\Transformation\Resizer\ImageMagick as Resizer;

class ImageMagickTest extends \PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $width = 10;
    $height = 10;
    $this->resource = new \Imagick(__DIR__.'/../../../fixtures/20x20-pattern.jpg');

    $this->image = $this->getMock('\ImageTransform\Image', array('create', 'open', 'flush', 'save', 'saveAs', 'initialize'));
    $this->image->set('image.resource', $this->resource);
    $this->image->set('image.width', $width);
    $this->image->set('image.height', $height);

    $this->resize = new Resizer();
  }

  /**
   * @covers \ImageTransform\Transformation\Resizer\ImageMagick::doResize
   */
  public function testResizing()
  {
    $width = 20;
    $height = 20;

    $this->image = $this->resize->resize($this->image, $width, $height);
    $this->assertEquals($width, $this->image->get('image.width'));
    $this->assertEquals($height, $this->image->get('image.height'));
    $this->assertInstanceOf('\Imagick', $this->image->get('image.resource'));
  }
}
