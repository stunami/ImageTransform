<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Processor;

use ImageTransform\Image;

interface ProcessorInterface
{
  public function addTransformation($method, $class, $alias = null);
  
  public function addTransformations(array $transformations);
  
  public function process(Image $image);
}
