<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Tests\Image\Transformation\Resize;

use ImageTransform\Image;
use ImageTransform\Image\Transformation\Resize\GD as Resize;

class GDTest extends \PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $width = 10;
    $height = 10;
    $this->resource = imagecreatetruecolor($width, $height);

    $image = new Image();
    $image->set('image.resource', $this->resource);
    $image->set('image.width', $width);
    $image->set('image.height', $height);

    $this->resize = new Resize($image);
  }

  public function testResizing()
  {
    $width = 20;
    $height = 20;

    $image = $this->resize->resize($width, $height);
    $this->assertEquals($width, $image->get('image.width'));
    $this->assertEquals($height, $image->get('image.height'));
    $this->assertNotEquals($this->resource, $image->get('image.resource'));
    $this->assertInternalType('resource', $image->get('image.resource'));
  }
}
