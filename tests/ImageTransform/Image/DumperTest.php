<?php

namespace ImageTransform\Tests\Image;

use ImageTransform\Image;
use ImageTransform\Image\Dumper;

class DumperTest extends \PHPUnit_Framework_TestCase
{
  public function testNewDumper()
  {
    $image = new Image();
    $dumper = $this->getMock('\ImageTransform\Image\Dumper', array('doFlush'), array($image));
    $this->assertInstanceOf('ImageTransform\Image\Dumper', $dumper);

    return $dumper;
  }

  /**
   * @depends testNewDumper
   */
  public function testDumpingToStdout($dumper)
  {
    ob_start();
    $image = $dumper->flush();
    $this->assertInstanceOf('ImageTransform\Image', $image);
    $this->assertEmpty(ob_get_contents());
    ob_end_clean();
  }

  public function testSavingOverOriginal()
  {
    $image = new Image();
    $dumper = $this->getMock('\ImageTransform\Image\Dumper', array('doFlush'), array($image));

    $filepath = '/tmp/ImageTransformTestImage.jpg';
    $this->assertFileNotExists($filepath);
    $image->set('image.filepath', $filepath);
    $image = $dumper->save();
    $this->assertInstanceOf('ImageTransform\Image', $image);
    $this->assertFileExists($filepath);

    unlink($filepath);
  }

  /**
   * @depends testNewDumper
   * @expectedException \InvalidArgumentException
   */
  public function testSavingWithNoFilepath()
  {
    $dumper = $this->getMock('\ImageTransform\Image\Dumper', array('doFlush'), array(new Image()));
    $dumper->save();
  }

  /**
   * @depends testNewDumper
   */
  public function testSavingWithPassedFilepath($dumper)
  {
    $filepath = '/tmp/ImageTransformTestImage.jpg';
    $this->assertFileNotExists($filepath);
    $image = $dumper->save($filepath);
    $this->assertInstanceOf('ImageTransform\Image', $image);
    $this->assertFileExists($filepath);

    unlink($filepath);
  }
}
