<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
