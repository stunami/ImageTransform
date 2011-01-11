<?php

namespace ImageTransfrom\Test\Image\Transformation\Resize;

use ImageTransform\Image;
use ImageTransform\Image\Transformation\Resize;

class ResizeTest extends \PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->image = new Image();
    $this->resize = $this->getMock('\ImageTransform\Image\Transformation\Resize', array('doResize'), array($this->image));
    $this->resize->expects($this->any())->method('doResize')->will($this->returnValue(true));
  }

  /**
   * @dataProvider transformations
   */
  public function testComputingDimansions($sourceDimensions, $targetDimensions, $resultDimensions, $options)
  {
    $this->image->set('image.width', $sourceDimensions[0]);
    $this->image->set('image.height', $sourceDimensions[1]);

    $this->resize->resize($targetDimensions[0], $targetDimensions[1], $options);

    $this->assertEquals($resultDimensions[0], $this->image->get('image.width'));
    $this->assertEquals($resultDimensions[1], $this->image->get('image.height'));
  }

  public static function transformations()
  {
    return array(
      array(array(10,10), array(16,24), array(16,16), Resize::PROPORTIONAL),
      array(array(10,10), array(16,24), array(24,24), Resize::PROPORTIONAL | Resize::MINIMUM),
      array(array(10,10), array(16,24), array(16,16), Resize::PROPORTIONAL | Resize::NO_DEFLATE),
      array(array(10,10), array(16,24), array(24,24), Resize::PROPORTIONAL | Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array(10,10), array(16,24), array(10,10), Resize::PROPORTIONAL | Resize::NO_INFLATE),
      array(array(10,10), array(16,24), array(10,10), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::MINIMUM),
      array(array(10,10), array(16,24), array(10,10), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::NO_DEFLATE),
      array(array(10,10), array(16,24), array(10,10), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array(10,10), array(16,24), array(16,24), 0),
      array(array(10,10), array(16,24), array(16,24), Resize::MINIMUM),
      array(array(10,10), array(16,24), array(16,24), Resize::NO_DEFLATE),
      array(array(10,10), array(16,24), array(16,24), Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array(10,10), array(16,24), array(10,10), Resize::NO_INFLATE),
      array(array(10,10), array(16,24), array(10,10), Resize::NO_INFLATE | Resize::MINIMUM),
      array(array(10,10), array(16,24), array(10,10), Resize::NO_INFLATE | Resize::NO_DEFLATE),
      array(array(10,10), array(16,24), array(10,10), Resize::NO_INFLATE | Resize::NO_DEFLATE | Resize::MINIMUM),

      array(array(16,24), array(10,10), array( 7,10), Resize::PROPORTIONAL),
      array(array(16,24), array(10,10), array(10,15), Resize::PROPORTIONAL | Resize::MINIMUM),
      array(array(16,24), array(10,10), array(16,24), Resize::PROPORTIONAL | Resize::NO_DEFLATE),
      array(array(16,24), array(10,10), array(16,24), Resize::PROPORTIONAL | Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array(16,24), array(10,10), array( 7,10), Resize::PROPORTIONAL | Resize::NO_INFLATE),
      array(array(16,24), array(10,10), array(10,15), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::MINIMUM),
      array(array(16,24), array(10,10), array(16,24), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::NO_DEFLATE),
      array(array(16,24), array(10,10), array(16,24), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array(16,24), array(10,10), array(10,10), 0),
      array(array(16,24), array(10,10), array(10,10), Resize::MINIMUM),
      array(array(16,24), array(10,10), array(16,24), Resize::NO_DEFLATE),
      array(array(16,24), array(10,10), array(16,24), Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array(16,24), array(10,10), array(10,10), Resize::NO_INFLATE),
      array(array(16,24), array(10,10), array(10,10), Resize::NO_INFLATE | Resize::MINIMUM),
      array(array(16,24), array(10,10), array(16,24), Resize::NO_INFLATE | Resize::NO_DEFLATE),
      array(array(16,24), array(10,10), array(16,24), Resize::NO_INFLATE | Resize::NO_DEFLATE | Resize::MINIMUM),

      array(array(16, 8), array(10,10), array(10, 5), Resize::PROPORTIONAL),
      array(array(16, 8), array(10,10), array(20,10), Resize::PROPORTIONAL | Resize::MINIMUM),
      array(array(16, 8), array(10,10), array(16, 8), Resize::PROPORTIONAL | Resize::NO_DEFLATE),
      array(array(16, 8), array(10,10), array(20,10), Resize::PROPORTIONAL | Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array(16, 8), array(10,10), array(10, 5), Resize::PROPORTIONAL | Resize::NO_INFLATE),
      array(array(16, 8), array(10,10), array(16, 8), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::MINIMUM),
      array(array(16, 8), array(10,10), array(16, 8), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::NO_DEFLATE),
      array(array(16, 8), array(10,10), array(16, 8), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array(16, 8), array(10,10), array(10,10), 0),
      array(array(16, 8), array(10,10), array(10,10), Resize::MINIMUM),
      array(array(16, 8), array(10,10), array(16,10), Resize::NO_DEFLATE),
      array(array(16, 8), array(10,10), array(16,10), Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array(16, 8), array(10,10), array(10, 8), Resize::NO_INFLATE),
      array(array(16, 8), array(10,10), array(10, 8), Resize::NO_INFLATE | Resize::MINIMUM),
      array(array(16, 8), array(10,10), array(16, 8), Resize::NO_INFLATE | Resize::NO_DEFLATE),
      array(array(16, 8), array(10,10), array(16, 8), Resize::NO_INFLATE | Resize::NO_DEFLATE | Resize::MINIMUM),

      array(array( 8,24), array(10,10), array( 3,10), Resize::PROPORTIONAL),
      array(array( 8,24), array(10,10), array(10,30), Resize::PROPORTIONAL | Resize::MINIMUM),
      array(array( 8,24), array(10,10), array( 8,24), Resize::PROPORTIONAL | Resize::NO_DEFLATE),
      array(array( 8,24), array(10,10), array(10,30), Resize::PROPORTIONAL | Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array( 8,24), array(10,10), array( 3,10), Resize::PROPORTIONAL | Resize::NO_INFLATE),
      array(array( 8,24), array(10,10), array( 8,24), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::MINIMUM),
      array(array( 8,24), array(10,10), array( 8,24), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::NO_DEFLATE),
      array(array( 8,24), array(10,10), array( 8,24), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array( 8,24), array(10,10), array(10,10), 0),
      array(array( 8,24), array(10,10), array(10,10), Resize::MINIMUM),
      array(array( 8,24), array(10,10), array(10,24), Resize::NO_DEFLATE),
      array(array( 8,24), array(10,10), array(10,24), Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array( 8,24), array(10,10), array( 8,10), Resize::NO_INFLATE),
      array(array( 8,24), array(10,10), array( 8,10), Resize::NO_INFLATE | Resize::MINIMUM),
      array(array( 8,24), array(10,10), array( 8,24), Resize::NO_INFLATE | Resize::NO_DEFLATE),
      array(array( 8,24), array(10,10), array( 8,24), Resize::NO_INFLATE | Resize::NO_DEFLATE | Resize::MINIMUM),

      array(array(10,10), array(10,10), array(10,10), Resize::PROPORTIONAL),
      array(array(10,10), array(10,10), array(10,10), Resize::PROPORTIONAL | Resize::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), Resize::PROPORTIONAL | Resize::NO_DEFLATE),
      array(array(10,10), array(10,10), array(10,10), Resize::PROPORTIONAL | Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), Resize::PROPORTIONAL | Resize::NO_INFLATE),
      array(array(10,10), array(10,10), array(10,10), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::NO_DEFLATE),
      array(array(10,10), array(10,10), array(10,10), Resize::PROPORTIONAL | Resize::NO_INFLATE | Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), 0),
      array(array(10,10), array(10,10), array(10,10), Resize::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), Resize::NO_DEFLATE),
      array(array(10,10), array(10,10), array(10,10), Resize::NO_DEFLATE | Resize::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), Resize::NO_INFLATE),
      array(array(10,10), array(10,10), array(10,10), Resize::NO_INFLATE | Resize::MINIMUM),
      array(array(10,10), array(10,10), array(10,10), Resize::NO_INFLATE | Resize::NO_DEFLATE),
      array(array(10,10), array(10,10), array(10,10), Resize::NO_INFLATE | Resize::NO_DEFLATE | Resize::MINIMUM)
    );
  }
}
