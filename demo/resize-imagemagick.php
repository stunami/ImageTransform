<?php

namespace ImageTransform\Demo;

require __DIR__.'/../src/autoload.php';

use ImageTransform\Image\ImageMagick as Image;
use ImageTransform\Transformation;
use ImageTransform\Transformation\Resizer\ImageMagick as Resizer;

// REGISTER TRANSFORMATION CALLBACKS
Transformation::addTransformation(new Resizer());

// INSTANTIATION
$transformation = new Transformation();

// CONFIGURING TRANSFORMATION STACK
$transformation->resize(100, 100, Resizer::PROPORTIONAL | Resizer::MINIMUM);

// PROCESSING IMAGE
$filepath = __DIR__.'/images/green-hornet.jpg';
$image = new Image($filepath);
$transformation->process($image);
$image->saveAs(__DIR__.'/_resized-imagemagick.jpg');
