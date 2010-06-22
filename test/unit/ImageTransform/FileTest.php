<?php
require_once 'AbstractTest.php';

/**
 * ImageTransform_File test case.
 */
class ImageTransform_FileTest extends ImageTransform_AbstractTest
{
  public function testConstructExistingFile()
  {
    $file = new ImageTransform_File($this->getImageFixturesPath() . '/Default.png');

    $this->assertType('ImageTransform_File', $file);
    $this->assertTrue($file->exists());
  }

  public function testConstructNonExistingFile()
  {
    $file = new ImageTransform_File($this->getImageFixturesPath() . '/XX_nonExisting.png');

    $this->assertType('ImageTransform_File', $file);
    $this->assertFalse($file->exists());
  }

  public function testSetFilepathFailsIfDirDoesNotExist()
  {
    $file = new ImageTransform_File();

    $this->setExpectedException('ImageTransform_File_NotFoundException');
    $file->setFilepath($this->getFixturesPath() . '/XX_nonExisting/XX_nonExisting.png');
  }

  public function testSetMimeResolveStrategyByStrategyNameFailsForNonExistingStrategy()
  {
    $file = new ImageTransform_File($this->getImageFixturesPath() . '/Default.png');

    $this->setExpectedException('ImageTransform_MimeType_Resolve_Strategy_Exception');
    $file->setMimeResolveStrategyByStrategyName('NonExistingStrategy');
  }

  public function testSetMimeResolveStrategy()
  {
    $file = new ImageTransform_File($this->getImageFixturesPath() . '/Default.png');

    $file->setMimeResolveStrategy(new ImageTransform_MimeType_Resolve_Strategy_Mock());
  }

  public function testGetMimeType()
  {
    $file = new ImageTransform_File($this->getImageFixturesPath() . '/Default.png');

    $file->setMimeResolveStrategy(new ImageTransform_MimeType_Resolve_Strategy_Mock('mock_mime_type'));
    $this->assertEquals('mock_mime_type', $file->getMimeType(true));
  }

  public function testGetMimeTypeFailsForUnkonwnFiles()
  {
    $file = new ImageTransform_File($this->getImageFixturesPath() . '/Default.png');

    $file->setMimeResolveStrategy(new ImageTransform_MimeType_Resolve_Strategy_Mock());
    $this->setExpectedException('ImageTransform_MimeType_Resolve_Strategy_Exception');
    $this->assertFalse($file->getMimeType(true));
  }

  public function testGetMimeTypeForExistingFilesWithNoStrategySet()
  {
    $file = new ImageTransform_File($this->getImageFixturesPath() . '/Default.png');

    $this->assertTrue($file->exists());
    $this->assertEquals('image/png', $file->getMimeType(true));
  }

  public function testGetMimeTypeForNewFiles()
  {
    $file = new ImageTransform_File($this->getImageFixturesPath() . '/XX_nonExisting.png');

    $this->assertFalse($file->exists());
    $this->assertEquals('image/png', $file->getMimeType(true));
  }

  public function testGetMimeTypeFailsForNewFilesWithNonExistingExtension()
  {
    $file = new ImageTransform_File($this->getFixturesPath() . '/fileWith.nonExistingExtension');

    $this->assertFalse($file->exists());
    $this->setExpectedException('ImageTransform_MimeType_Resolve_Strategy_Exception');
    $file->getMimeType(true);
  }

  public function testToString()
  {
    $filepath = $this->getImageFixturesPath() . '/Default.png';
    $file = new ImageTransform_File($filepath);

    $this->assertType('ImageTransform_File', $file);
    $this->assertTrue($file->exists());
    $this->assertEquals(file_get_contents($filepath), $file->toString());
  }

  public function testToStringFailsForNewFiles()
  {
    $file = new ImageTransform_File($this->getImageFixturesPath() . '/XX_nonExisting.png');

    $this->setExpectedException('ImageTransform_File_NotFoundException');
    $file->toString();
  }

  public function testMagicToString()
  {
    $filepath = $this->getImageFixturesPath() . '/Default.png';
    $file = new ImageTransform_File($filepath);

    $this->assertType('ImageTransform_File', $file);
    $this->assertTrue($file->exists());

    ob_start();
    echo $file;
    $content = ob_get_contents();
    ob_end_clean();

    $this->assertEquals(file_get_contents($filepath), $content);
  }
}

