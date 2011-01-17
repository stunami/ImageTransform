<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Tests\Transformation;

use ImageTransform\Image;
use ImageTransform\Transformation\Dumper;

class DumperTest extends \PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->image = new Image();
    $this->dumper = $this->getMock('\ImageTransform\Transformation\Dumper', array('doFlush'), array($this->image));
  }

  public function testNewDumper()
  {
    $this->assertInstanceOf('ImageTransform\Transformation\Dumper', $this->dumper);
  }

  public function testDumpingToStdout()
  {
    ob_start();
    $image = $this->dumper->flush();
    $this->assertInstanceOf('ImageTransform\Image', $image);
    $this->assertEmpty(ob_get_contents());
    ob_end_clean();
  }

  public function testSavingOverOriginal()
  {
    $filepath = '/tmp/ImageTransformTestImage.jpg';
    $this->assertFileNotExists($filepath);
    $this->image->set('image.filepath', $filepath);
    $image = $this->dumper->save();
    $this->assertInstanceOf('ImageTransform\Image', $image);
    $this->assertFileExists($filepath);

    unlink($filepath);
  }

  /**
   * @expectedException \InvalidArgumentException
   */
  public function testSavingWithNoFilepath()
  {
    $this->dumper->save();
  }

  public function testSavingWithPassedFilepath()
  {
    $filepath = '/tmp/ImageTransformTestImage.jpg';
    $this->assertFileNotExists($filepath);
    $image = $this->dumper->save($filepath);
    $this->assertInstanceOf('ImageTransform\Image', $image);
    $this->assertFileExists($filepath);

    unlink($filepath);
  }
}
