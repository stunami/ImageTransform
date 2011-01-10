<?php

namespace ImageTransform\Tests;

use ImageTransform\Image;
use ImageTransform\Image\Dumper;

class DumperTest extends \PHPUnit_Framework_TestCase
{
  public function testNewDumper()
  {
    $image = new Image();
    $dumper = new Dumper($image);
    $this->assertInstanceOf('ImageTransform\Image\Dumper', $dumper);

    return $dumper;
  }

  /**
   * @depends testNewDumper
   */
  public function testDumpingToStdout($dumper)
  {
    ob_start();
    $dumper->out();
    $this->assertNotEmpty(ob_get_contents());
    ob_end_clean();
  }

  public function testSavingOverOriginal()
  {
    $image = new Image();
    $dumper = new Dumper($image);

    $filepath = '/tmp/ImageTransformTestImage.jpg';
    $this->assertFileNotExists($filepath);
    $image->set('image.filepath', $filepath);
    $dumper->save();
    $this->assertFileExists($filepath);

    unlink($filepath);
  }

  /**
   * @depends testNewDumper
   * @expectedException \InvalidArgumentException
   */
  public function testSavingWithNoFilepath()
  {
    $dumper = new Dumper(new Image());
    $dumper->save();
  }

  /**
   * @depends testNewDumper
   */
  public function testSavingWithPassedFilepath($dumper)
  {
    $filepath = '/tmp/ImageTransformTestImage.jpg';
    $this->assertFileNotExists($filepath);
    $dumper->saveAs($filepath);
    $this->assertFileExists($filepath);

    unlink($filepath);
  }
}
