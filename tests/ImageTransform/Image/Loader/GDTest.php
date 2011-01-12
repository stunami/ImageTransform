<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Tests\Image\Loader;

use ImageTransform\Image;
use ImageTransform\Image\Loader\GD as Loader;

class GDTest extends \PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->image = new Image(array('\ImageTransform\Image\Loader\GD'));
    $this->loader = new Loader($this->image);
  }

  public function testNewLoader()
  {
    $this->assertInstanceOf('ImageTransform\Image\Loader\GD', $this->loader);
    $this->assertEquals('GD', $this->image->get('core.image_api'));

    return $this->loader;
  }

  public function testCreation()
  {
    $width = 80;
    $height = 100;

    $image = $this->loader->create($width, $height);

    $this->assertInternalType('resource', $image->get('image.resource'));
    $this->assertFalse($image->get('image.mimeType'));
    $this->assertEquals($width, $image->get('image.width'));
    $this->assertEquals($height, $image->get('image.height'));
  }

  /**
   * @dataProvider fixtureImages
   */
  public function testLoadingFromFile($filepath, $mimeType, $width, $height)
  {
    $image = $this->loader->open($filepath);

    $this->assertInternalType('resource', $image->get('image.resource'));
    $this->assertEquals($mimeType, $image->get('image.mime_type'));
    $this->assertEquals($width, $image->get('image.width'));
    $this->assertEquals($height, $image->get('image.height'));
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testLoadingFromNonExistingFile()
  {
    $this->loader->open('/this/image/does/not/exist.jpg');
  }

  /**
   * @expectedException \ImageTransform\Image\Exception\MimeTypeNotSupportedException
   */
  public function testLoadingFromFileOfWrongMimeType()
  {
    $this->loader->open(__FILE__);
  }

  public static function fixtureImages()
  {
    return array(
      array(__DIR__.'/../../../fixtures/20x20-pattern.gif', 'image/gif', 20, 20),
      array(__DIR__.'/../../../fixtures/20x20-pattern.jpg', 'image/jpeg', 20, 20),
      array(__DIR__.'/../../../fixtures/20x20-pattern.png', 'image/png', 20, 20)
    );
  }
}
