<?php

namespace ImageTransform\Demo;

require __DIR__.'/../src/autoload.php';

use ImageTransform\Image;
use ImageTransform\Image\Transformation\Resize;

$image = new Image(array(
  'ImageTransform\Image\Loader\GD',
  'ImageTransform\Image\Dumper\GD',
  'ImageTransform\Image\Transformation\Resize\GD',
));

$filepath = __DIR__.'/images/green-hornet.jpg';

$image->open($filepath)
  ->resize(100, 100)
  ->save(__DIR__.'/_resized.jpg');

$image->open($filepath)
  ->resize(100, 100, Resize::PROPORTIONAL)
  ->save(__DIR__.'/_resized-prop.jpg');

$image->open($filepath)
  ->resize(100, 100, Resize::PROPORTIONAL | Resize::MINIMUM)
  ->save(__DIR__.'/_resized-propmin.jpg');

