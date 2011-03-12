<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Processor;

use ImageTransform\Processor;

use ImageTransform\Transformation\GDInterface;

class GD extends Processor implements ProcessorInterface
{
  public function isValidClass($class)
  {
    if (in_array('ImageTransform\\Transformation\\GDInterface', \class_implements($class)))
    {
      return true;
    }
    
    return false;
  }
}