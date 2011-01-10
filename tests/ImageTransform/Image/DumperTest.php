<?php

namespace ImageTransform\Tests;

use ImageTransform\Image;
use ImageTransform\Image\Dumper;

class DumperTest extends \PHPUnit_Framework_TestCase
{
  public function testNewDumper()
  {
    $image = new Image();
    $dumper = $this->getMock('\ImageTransform\Image\Dumper', array('dump'), array($image));
    $this->assertInstanceOf('ImageTransform\Image\Dumper', $dumper);

    return $dumper;
  }

  /**
   * @depends testNewDumper
   */
  public function testDumpingToStdout($dumper)
  {
    ob_start();
    $image = $dumper->out();
    $this->assertInstanceOf('ImageTransform\Image', $image);
    $this->assertEmpty(ob_get_contents());
    ob_end_clean();
  }

  public function testSavingOverOriginal()
  {
    $image = new Image();
    $dumper = $this->getMock('\ImageTransform\Image\Dumper', array('dump'), array($image));

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
    $dumper = $this->getMock('\ImageTransform\Image\Dumper', array('dump'), array(new Image()));
    $dumper->save();
  }

  /**
   * @depends testNewDumper
   */
  public function testSavingWithPassedFilepath($dumper)
  {
    $filepath = '/tmp/ImageTransformTestImage.jpg';
    $this->assertFileNotExists($filepath);
    $image = $dumper->saveAs($filepath);
    $this->assertInstanceOf('ImageTransform\Image', $image);
    $this->assertFileExists($filepath);

    unlink($filepath);
  }
}
