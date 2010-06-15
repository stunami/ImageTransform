<?php
require_once 'AbstractTest.php';

/**
 * ImageTransform_Source test case.
 */
class ImageTransform_SourceTest extends ImageTransform_AbstractTest
{

  public function testConstructingImageWithInvalidAdapterFail()
  {
    $message = 'must be an instance of ImageTransform_Adapter_Interface, ';

    $this->setExpectedException('Exception', $message . 'none given');
    new ImageTransform_Source();

    $this->setExpectedException('Exception', $message . 'string given');
    new ImageTransform_Source('nonExistentAdapter');

    $this->setExpectedException('Exception', $message . 'instance of ImageTransform_SourceTest given');
    new ImageTransform_Source($this);
  }

  public function testCreatesCorrectDefaultImage()
  {
    $fixture = $this->getFixturesPath() . '/Default.png';

    $expected = new ImageTransform_Source($this->getNewAdapter(), $fixture, 'image/png');
    $actual = new ImageTransform_Source($this->getNewAdapter());

    $this->assertEquals($expected->toString(), $actual->toString());
  }
}

