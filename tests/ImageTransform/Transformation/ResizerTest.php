<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransfrom\Test\Transformation\Resizer;

use ImageTransform\Image;
use ImageTransform\Transformation\Resizer;

class ResizerTest extends \PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->image = $this->getMock('\ImageTransform\Image', array('create', 'open', 'flush', 'save', 'saveAs'));
    $this->resize = $this->getMock('\ImageTransform\Transformation\Resizer', array('doResize'));
    $this->resize->expects($this->any())->method('doResize')->will($this->returnValue(true));
  }

  /**
   * @dataProvider transformations
   * @covers \ImageTransform\Transformation\Resizer::resize
   * @covers \ImageTransform\Transformation\Resizer::computeFinalDimension
   */
  public function testComputingDimansions($sourceDimensions, $targetDimensions, $resultDimensions, $options)
  {
    $this->image->set('image.width', $sourceDimensions[0]);
    $this->image->set('image.height', $sourceDimensions[1]);

    $this->resize->resize($this->image, $targetDimensions[0], $targetDimensions[1], $options);

    $this->assertEquals($resultDimensions[0], $this->image->get('image.width'));
    $this->assertEquals($resultDimensions[1], $this->image->get('image.height'));
  }

  public static function transformations()
  {
    return array(
      array(array(10,10), array(16,24), array(16,16), Resizer::PROPORTIONAL),
      array(array(10,10), array(16,24), array(24,24), Resizer::PROPORTIONAL | Resizer::MINIMUM),
      array(array(10,10), array(16,24), array(16,16), Resizer::PROPORTIONAL | Resizer::NO_DEFLATE),
      array(array(10,10), array(16,24), array(24,24), Resizer::PROPORTIONAL | Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array(10,10), array(16,24), array(10,10), Resizer::PROPORTIONAL | Resizer::NO_INFLATE),
      array(array(10,10), array(16,24), array(10,10), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::MINIMUM),
      array(array(10,10), array(16,24), array(10,10), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::NO_DEFLATE),
      array(array(10,10), array(16,24), array(10,10), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array(10,10), array(16,24), array(16,24), 0),
      array(array(10,10), array(16,24), array(16,24), Resizer::MINIMUM),
      array(array(10,10), array(16,24), array(16,24), Resizer::NO_DEFLATE),
      array(array(10,10), array(16,24), array(16,24), Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array(10,10), array(16,24), array(10,10), Resizer::NO_INFLATE),
      array(array(10,10), array(16,24), array(10,10), Resizer::NO_INFLATE | Resizer::MINIMUM),
      array(array(10,10), array(16,24), array(10,10), Resizer::NO_INFLATE | Resizer::NO_DEFLATE),
      array(array(10,10), array(16,24), array(10,10), Resizer::NO_INFLATE | Resizer::NO_DEFLATE | Resizer::MINIMUM),

      array(array(16,24), array(10,10), array( 7,10), Resizer::PROPORTIONAL),
      array(array(16,24), array(10,10), array(10,15), Resizer::PROPORTIONAL | Resizer::MINIMUM),
      array(array(16,24), array(10,10), array(16,24), Resizer::PROPORTIONAL | Resizer::NO_DEFLATE),
      array(array(16,24), array(10,10), array(16,24), Resizer::PROPORTIONAL | Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array(16,24), array(10,10), array( 7,10), Resizer::PROPORTIONAL | Resizer::NO_INFLATE),
      array(array(16,24), array(10,10), array(10,15), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::MINIMUM),
      array(array(16,24), array(10,10), array(16,24), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::NO_DEFLATE),
      array(array(16,24), array(10,10), array(16,24), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array(16,24), array(10,10), array(10,10), 0),
      array(array(16,24), array(10,10), array(10,10), Resizer::MINIMUM),
      array(array(16,24), array(10,10), array(16,24), Resizer::NO_DEFLATE),
      array(array(16,24), array(10,10), array(16,24), Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array(16,24), array(10,10), array(10,10), Resizer::NO_INFLATE),
      array(array(16,24), array(10,10), array(10,10), Resizer::NO_INFLATE | Resizer::MINIMUM),
      array(array(16,24), array(10,10), array(16,24), Resizer::NO_INFLATE | Resizer::NO_DEFLATE),
      array(array(16,24), array(10,10), array(16,24), Resizer::NO_INFLATE | Resizer::NO_DEFLATE | Resizer::MINIMUM),

      array(array(16, 8), array(10,10), array(10, 5), Resizer::PROPORTIONAL),
      array(array(16, 8), array(10,10), array(20,10), Resizer::PROPORTIONAL | Resizer::MINIMUM),
      array(array(16, 8), array(10,10), array(16, 8), Resizer::PROPORTIONAL | Resizer::NO_DEFLATE),
      array(array(16, 8), array(10,10), array(20,10), Resizer::PROPORTIONAL | Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array(16, 8), array(10,10), array(10, 5), Resizer::PROPORTIONAL | Resizer::NO_INFLATE),
      array(array(16, 8), array(10,10), array(16, 8), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::MINIMUM),
      array(array(16, 8), array(10,10), array(16, 8), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::NO_DEFLATE),
      array(array(16, 8), array(10,10), array(16, 8), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array(16, 8), array(10,10), array(10,10), 0),
      array(array(16, 8), array(10,10), array(10,10), Resizer::MINIMUM),
      array(array(16, 8), array(10,10), array(16,10), Resizer::NO_DEFLATE),
      array(array(16, 8), array(10,10), array(16,10), Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array(16, 8), array(10,10), array(10, 8), Resizer::NO_INFLATE),
      array(array(16, 8), array(10,10), array(10, 8), Resizer::NO_INFLATE | Resizer::MINIMUM),
      array(array(16, 8), array(10,10), array(16, 8), Resizer::NO_INFLATE | Resizer::NO_DEFLATE),
      array(array(16, 8), array(10,10), array(16, 8), Resizer::NO_INFLATE | Resizer::NO_DEFLATE | Resizer::MINIMUM),

      array(array( 8,24), array(10,10), array( 3,10), Resizer::PROPORTIONAL),
      array(array( 8,24), array(10,10), array(10,30), Resizer::PROPORTIONAL | Resizer::MINIMUM),
      array(array( 8,24), array(10,10), array( 8,24), Resizer::PROPORTIONAL | Resizer::NO_DEFLATE),
      array(array( 8,24), array(10,10), array(10,30), Resizer::PROPORTIONAL | Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array( 8,24), array(10,10), array( 3,10), Resizer::PROPORTIONAL | Resizer::NO_INFLATE),
      array(array( 8,24), array(10,10), array( 8,24), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::MINIMUM),
      array(array( 8,24), array(10,10), array( 8,24), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::NO_DEFLATE),
      array(array( 8,24), array(10,10), array( 8,24), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array( 8,24), array(10,10), array(10,10), 0),
      array(array( 8,24), array(10,10), array(10,10), Resizer::MINIMUM),
      array(array( 8,24), array(10,10), array(10,24), Resizer::NO_DEFLATE),
      array(array( 8,24), array(10,10), array(10,24), Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array( 8,24), array(10,10), array( 8,10), Resizer::NO_INFLATE),
      array(array( 8,24), array(10,10), array( 8,10), Resizer::NO_INFLATE | Resizer::MINIMUM),
      array(array( 8,24), array(10,10), array( 8,24), Resizer::NO_INFLATE | Resizer::NO_DEFLATE),
      array(array( 8,24), array(10,10), array( 8,24), Resizer::NO_INFLATE | Resizer::NO_DEFLATE | Resizer::MINIMUM),

      array(array(10,10), array(10,10), array(10,10), Resizer::PROPORTIONAL),
      array(array(10,10), array(10,10), array(10,10), Resizer::PROPORTIONAL | Resizer::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), Resizer::PROPORTIONAL | Resizer::NO_DEFLATE),
      array(array(10,10), array(10,10), array(10,10), Resizer::PROPORTIONAL | Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), Resizer::PROPORTIONAL | Resizer::NO_INFLATE),
      array(array(10,10), array(10,10), array(10,10), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::NO_DEFLATE),
      array(array(10,10), array(10,10), array(10,10), Resizer::PROPORTIONAL | Resizer::NO_INFLATE | Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), 0),
      array(array(10,10), array(10,10), array(10,10), Resizer::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), Resizer::NO_DEFLATE),
      array(array(10,10), array(10,10), array(10,10), Resizer::NO_DEFLATE | Resizer::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), Resizer::NO_INFLATE),
      array(array(10,10), array(10,10), array(10,10), Resizer::NO_INFLATE | Resizer::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), Resizer::NO_INFLATE | Resizer::NO_DEFLATE),
      array(array(10,10), array(10,10), array(10,10), Resizer::NO_INFLATE | Resizer::NO_DEFLATE | Resizer::MINIMUM)
    );
  }
}
