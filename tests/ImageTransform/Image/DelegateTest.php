<?php

namespace ImageTransform\Tests\Image;

use ImageTransform\Image;
use ImageTransform\Image\Delegate;

class DelegateTest extends \PHPUnit_Framework_TestCase
{
  public function testNewDelegate()
  {
    $image = new Image();
    $stubDelegate = $this->getMock('ImageTransform\Image\Delegate', array(), array($image));
    $this->assertObjectHasAttribute('image', $stubDelegate);
  }
}
