<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Tests\Transformation\Dumper;

use ImageTransform\Image;
use ImageTransform\Transformation\Dumper\GD as Dumper;

class GDTest extends \PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->image = new Image();
    $this->dumper = new Dumper($this->image);
  }

  /**
   * @dataProvider fixtureImages
   */
  public function testDumpingToStdout($imagecreateFunction, $fixtureImage, $mimeType)
  {
    $this->image->set('core.image_api', 'GD');
    $this->image->set('image.resource', $imagecreateFunction($fixtureImage));
    $this->image->set('image.mime_type', $mimeType);

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
   * @expectedException \ImageTransform\Transformation\Exception\MimeTypeNotSupportedException
   */
  public function testDumpingUnknowMimeType()
  {
    $this->image->set('core.image_api', 'GD');
    $this->image->set('image.resource', true);
    $this->image->set('image.mime_type', false);
    $this->dumper->flush();
  }

  public static function fixtureImages()
  {
    return array(
      array('imagecreatefromgif',  __DIR__.'/../../../fixtures/20x20-pattern.gif', 'image/gif'),
      array('imagecreatefromjpeg', __DIR__.'/../../../fixtures/20x20-pattern.jpg', 'image/jpg'),
      array('imagecreatefrompng',  __DIR__.'/../../../fixtures/20x20-pattern.png', 'image/png')
    );
  }
}
