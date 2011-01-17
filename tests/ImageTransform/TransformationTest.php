<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Tests;

use ImageTransform\Image;
use ImageTransform\Transformation;

class TransformationTest extends \PHPUnit_Framework_TestCase
{
  public function testNewTransformation()
  {
    $image = new Image();
    $stubDelegate = $this->getMock('ImageTransform\Transformation', array(), array($image));
    $this->assertObjectHasAttribute('image', $stubDelegate);
  }
}
