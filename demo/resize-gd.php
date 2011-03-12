<?php

namespace ImageTransform\Demo;

require __DIR__.'/../src/autoload.php';

use ImageTransform\Image\GD as Image;

use ImageTransform\Processor\GD as Processor;

// INSTANTIATION
$processor = new Processor();
$processor->addTransformations(array(array('method' => 'resize', 'class' => '\\ImageTransform\\Transformation\\Resizer\\GD')));
$processor->addTransformation('resize', '\\ImageTransform\\Transformation\\Resizer\\GD');

// CONFIGURING TRANSFORMATION STACK
$processor->resize(101, 101);

$more = clone $processor;
$more->resize(50, 50);

// PROCESSING IMAGE
$filepath = __DIR__.'/images/green-hornet.jpg';
$image = new Image($filepath);
$more->process($image);
$image->saveAs(__DIR__.'/_resized-gd.jpg');
