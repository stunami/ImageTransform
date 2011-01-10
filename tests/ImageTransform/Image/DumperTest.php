<?php

namespace ImageTransform\Tests;

use ImageTransform\Image;
use ImageTransform\Image\Dumper;

class DumperTest extends \PHPUnit_Framework_TestCase
{
  public function testNewDumper()
  {
    $image = new Image(array('ImageTransform\Image\Loader'));
    $image->from('/tmp/image.jpg');
    $dumper = new Dumper($image));
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

  /**
   * @depends testNewDumper
   */
  public function testSavingOverOriginal($dumper)
  {
    $dumper->save();
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
    $dumper->saveAs('/tmp/image.jpg');
  }
}
