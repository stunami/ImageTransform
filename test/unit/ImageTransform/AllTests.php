<?php

require_once 'PHPUnit/Framework/TestSuite.php';
//require_once 'test/unit/ImageTransform/Adapter/GdTest.php';
require_once 'FileTest.php';
require_once 'SourceTest.php';

/**
 * Static test suite.
 */
class ImageTransform_AllTests extends PHPUnit_Framework_TestSuite
{

  /**
   * Constructs the test suite handler.
   */
  public function __construct()
  {
    $this->setName('ImageTransform_AllTests');

    //$this->addTestSuite('ImageTransform_Adapter_GdTest');

    $this->addTestSuite('ImageTransform_FileTest');

    $this->addTestSuite('ImageTransform_SourceTest');

  }

  /**
   * Creates the suite.
   */
  public static function suite()
  {
    return new self();
  }
}

