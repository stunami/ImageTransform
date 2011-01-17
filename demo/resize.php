<?php

namespace ImageTransform\Demo;

require __DIR__.'/../src/autoload.php';

use ImageTransform\Transformation;
use ImageTransform\Image;
use ImageTransform\Image\Transformation\Resize;

$transformation = new Transformation(array(
  'ImageTransform\Image\Loader\GD',
  'ImageTransform\Image\Dumper\GD',
  'ImageTransform\Image\Transformation\Resize\GD',
));

$filepath = __DIR__.'/images/green-hornet.jpg';
$image = new Image($filepath);

$transformation->resize(100, 100, Resize::PROPORTIONAL | Resize::MINIMUM)
               ->save(__DIR__.'/_resized-propmin.jpg')
               ->process($image);

