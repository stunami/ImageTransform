<?php
require_once 'AbstractTest.php';

/**
 * ImageTransform_Source test case.
 */
class ImageTransform_SourceTest extends ImageTransform_AbstractTest
{
  private function getMockAdapter($name = 'Gd')
  {
    $adapter = $this->getMock('ImageTransform_Adapter_' . $name);
    $adapter->expects($this->any())
      ->method('getName')
      ->will($this->returnValue($name));

    return $adapter;
  }

  private function getMockFile($exists = false)
  {
    $file = $this->getMock('ImageTransform_File');
    $file->expects($this->any())
      ->method('exists')
      ->will($this->returnValue($exists));

    return $file;
  }

  public function testConstructingImageWithInvalidAdapterFail()
  {
    $message = 'ImageTransform_Adapter_Interface, ';
    $file = $this->getMockFile(true);

    $this->setExpectedException('Exception', $message . 'null given');
    $source = new ImageTransform_Source(null, $file);
    $this->assertNull($source);

    $this->setExpectedException('Exception', $message . 'string given');
    $source = new ImageTransform_Source('nonExistentAdapter', $file);
    $this->assertNull($source);

    $this->setExpectedException('Exception', $message . 'instance of ImageTransform_SourceTest given');
    $source = new ImageTransform_Source($this, $file);
    $this->assertNull($source);
  }

  public function testCreatesCorrectDefaultImage()
  {
    $fixture = new ImageTransform_File($this->getImageFixturesPath() . '/Default.png');
    $expected = new ImageTransform_Source($this->createAdapter(), $fixture);
    $actual = new ImageTransform_Source($this->createAdapter(), $this->getMockFile());
    $this->assertEquals($expected->toString(), $actual->toString());
  }

  public function testCopy()
  {
    $fixture = new ImageTransform_File($this->getImageFixturesPath() . '/Default.png');
    $source = new ImageTransform_Source($this->createAdapter(), $fixture);

    $this->assertEquals($source->toString(), $source->copy()->toString());
  }

  public function testLoadString()
  {
    $fixture = new ImageTransform_File($this->getImageFixturesPath() . '/Default.png');

    $source = new ImageTransform_Source($this->createAdapter(), $this->getMockFile());
    $source->loadString($fixture->toString());

    $this->assertEquals($fixture->toString(), $source->toString());
  }

  public function testGetsCorrectWidth()
  {
    $fixture = new ImageTransform_File($this->getImageFixturesPath() . '/Default.png');
    $source = new ImageTransform_Source($this->createAdapter(), $fixture);
    $this->assertEquals(100, $source->getWidth());
  }

  public function testGetsCorrectHeight()
  {
    $fixture = new ImageTransform_File($this->getImageFixturesPath() . '/Default.png');
    $source = new ImageTransform_Source($this->createAdapter(), $fixture);
    $this->assertEquals(100, $source->getHeight());
  }

  public function testGetsCorrectMime()
  {
    $fixture = new ImageTransform_File($this->getImageFixturesPath() . '/Default.png');
    $source = new ImageTransform_Source($this->createAdapter(), $fixture);
    $this->assertEquals('image/png', $source->getMIMEType());
  }

}

