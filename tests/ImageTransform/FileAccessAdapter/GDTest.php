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
use ImageTransform\FileAccessAdapter\GD as FileAccessAdapter;

class GDTest extends \PHPUnit_Framework_TestCase
{
  public function testCreation()
  {
    $width = 100;
    $height = 200;

    $image = new Image();
    $fileAccessAdapter = new FileAccessAdapter();
    $fileAccessAdapter->create($image, $width, $height);

    $this->assertInternalType('resource', $image->get('image.resource'));
    $this->assertEquals($width,  $image->get('image.width'));
    $this->assertEquals($height, $image->get('image.height'));
  }

  /**
   * @dataProvider fixtureImages
   */
  public function testOpening($filepath, $mimeType, $width, $height)
  {
    $image = new Image();
    $fileAccessAdapter = new FileAccessAdapter();
    $fileAccessAdapter->open($image, $filepath);

    $this->assertInternalType('resource', $image->get('image.resource'));
    $this->assertEquals($filepath, $image->get('image.filepath'));
    $this->assertEquals($width,    $image->get('image.width'));
    $this->assertEquals($height,   $image->get('image.height'));
    $this->assertEquals($mimeType, $image->get('image.mime_type'));
  }

  /**
   * @expectedException \InvalidArgumentException
   */
  public function testOpeningOfUnreadableFile()
  {
    $image = new Image();
    $fileAccessAdapter = new FileAccessAdapter();
    $fileAccessAdapter->open($image, '/does/not/exist');
  }

  /**
   * @expectedException \UnexpectedValueException
   */
  public function testOpeningOfUnsupportedMimeType()
  {
    $image = new Image();
    $fileAccessAdapter = new FileAccessAdapter();
    $fileAccessAdapter->open($image, __FILE__);
  }

  public function testFlushing()
  {
    $image = new Image();
    $fileAccessAdapter = new FileAccessAdapter();
    $fileAccessAdapter->open($image, __DIR__.'/../../fixtures/20x20-pattern.gif');

    ob_start();
    $fileAccessAdapter->flush($image);
    $this->assertNotEmpty(ob_get_contents());
    ob_end_clean();
  }

  /**
   * @expectedException \UnexpectedValueException
   */
  public function testFlushingWithNoResourceOpened()
  {
    $image = new Image();
    $fileAccessAdapter = new FileAccessAdapter();

    $fileAccessAdapter->flush($image);
  }

  public static function fixtureImages()
  {
    return array(
      array(__DIR__.'/../../fixtures/20x20-pattern.gif', 'image/gif', 20, 20),
      array(__DIR__.'/../../fixtures/20x20-pattern.jpg', 'image/jpeg', 20, 20),
      array(__DIR__.'/../../fixtures/20x20-pattern.png', 'image/png', 20, 20)
    );
  }
}
