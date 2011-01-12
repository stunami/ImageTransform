<?php

namespace ImageTransform\Tests\Image\Dumper;

use ImageTransform\Image;
use ImageTransform\Image\Dumper\GD as Dumper;

class GDTest extends \PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->image = new Image();
    $this->dumper = new Dumper($this->image);
  }

  public function testDumpingToStdout()
  {
    $this->image->set('core.image_api', 'GD');
    $this->image->set('image.resource', imagecreatefromjpeg(__DIR__.'/../../../fixtures/20x20-pattern.jpg'));
    $this->image->set('image.mime_type', 'image/jpeg');

    ob_start();
    $this->dumper->flush();
    $this->assertNotEmpty(ob_get_contents());
    ob_end_clean();
  }

  /**
   * @expectedException \UnexpectedValueException
   */
  public function testDumpingWrongImageApi()
  {
    $this->image->set('core.image_api', false);
    $this->image->set('image.resource', false);
    $this->image->set('image.mime_type', false);
    $this->dumper->flush();
  }

  /**
   * @expectedException \UnexpectedValueException
   */
  public function testDumpingNoresource()
  {
    $this->image->set('core.image_api', 'GD');
    $this->image->set('image.resource', false);
    $this->image->set('image.mime_type', false);
    $this->dumper->flush();
  }

  /**
   * @expectedException \ImageTransform\Image\Exception\MimeTypeNotSupportedException
   */
  public function testDumpingUnknowMimeType()
  {
    $this->image->set('core.image_api', 'GD');
    $this->image->set('image.resource', true);
    $this->image->set('image.mime_type', false);
    $this->dumper->flush();
  }
}
