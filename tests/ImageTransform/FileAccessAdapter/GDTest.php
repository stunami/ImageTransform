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
  /**
   * @covers \ImageTransform\FileAccessAdapter\GD::create
   */
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
   * @covers \ImageTransform\FileAccessAdapter\GD::open
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
   * @covers \ImageTransform\FileAccessAdapter\GD::open
   */
  public function testOpeningOfUnreadableFile()
  {
    $image = new Image();
    $fileAccessAdapter = new FileAccessAdapter();
    $fileAccessAdapter->open($image, '/does/not/exist');
  }

  /**
   * @expectedException \UnexpectedValueException
   * @covers \ImageTransform\FileAccessAdapter\GD::open
   */
  public function testOpeningOfUnsupportedMimeType()
  {
    $image = new Image();
    $fileAccessAdapter = new FileAccessAdapter();
    $fileAccessAdapter->open($image, __FILE__);
  }

  /**
   * @covers \ImageTransform\FileAccessAdapter\GD::flush
   */
  public function testFlushing()
  {
    $image = new Image();
    $fileAccessAdapter = $this->getMock('\ImageTransform\FileAccessAdapter\GD', array('out'));
    $fileAccessAdapter->expects($this->once())->method('out');

    $fileAccessAdapter->flush($image);
  }

  /**
   * @covers \ImageTransform\FileAccessAdapter\GD::save
   */
  public function testSaving()
  {
    $image = new Image();
    $image->set('image.filepath', '/does/not/exist');

    $fileAccessAdapter = $this->getMock('\ImageTransform\FileAccessAdapter\GD', array('saveAs'));
    $fileAccessAdapter->expects($this->once())->method('saveAs');
    $fileAccessAdapter->save($image);
  }

  /**
   * @expectedException \InvalidArgumentException
   * @covers \ImageTransform\FileAccessAdapter\GD::save
   */
  public function testSavingWithNoFilepath()
  {
    $image = new Image();

    $fileAccessAdapter = $this->getMock('\ImageTransform\FileAccessAdapter\GD', array('saveAs'));
    $fileAccessAdapter->expects($this->never())->method('saveAs');
    $fileAccessAdapter->save($image);
  }

  /**
   * @covers \ImageTransform\FileAccessAdapter\GD::saveAs
   */
  public function testSavingAtGivenFilepath()
  {
    $image = new Image();

    $fileAccessAdapter = $this->getMock('\ImageTransform\FileAccessAdapter\GD', array('out'));
    $fileAccessAdapter->expects($this->once())->method('out');
    $fileAccessAdapter->saveAs($image, __FILE__);
  }

  /**
   * @expectedException \InvalidArgumentException
   * @covers \ImageTransform\FileAccessAdapter\GD::saveAs
   */
  public function testSavingAtGivenUnwritableFilepath()
  {
    $image = new Image();

    $fileAccessAdapter = $this->getMock('\ImageTransform\FileAccessAdapter\GD', array('out'));
    $fileAccessAdapter->expects($this->never())->method('out');
    $fileAccessAdapter->saveAs($image, '/does/not/exist');
  }

  /**
   * @dataProvider fixtureImages
   * @covers \ImageTransform\FileAccessAdapter\GD::out
   */
  public function testFlushingDifferentMimeTypes($filepath, $mimeType, $width, $height)
  {
    $image = new Image();
    $fileAccessAdapter = new FileAccessAdapter();
    $fileAccessAdapter->open($image, $filepath);

    ob_start();
    $fileAccessAdapter->flush($image);
    $this->assertNotEmpty(ob_get_contents());
    ob_end_clean();
  }

  /**
   * @expectedException \UnexpectedValueException
   * @covers \ImageTransform\FileAccessAdapter\GD::out
   */
  public function testFlushingWhenNoResourceIsSet()
  {
    $image = new Image();
    $fileAccessAdapter = new FileAccessAdapter();

    $fileAccessAdapter->flush($image);
  }

  /**
   * @expectedException \UnexpectedValueException
   * @covers \ImageTransform\FileAccessAdapter\GD::out
   */
  public function testFlushingUnsupportedMimeType()
  {
    $image = new Image();
    $image->set('image.resource', true);
    $image->set('image.resource', 'unsupported/mimetype');

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
