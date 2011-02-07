<?php

namespace ImageTransform\Demo;

require __DIR__.'/../src/autoload.php';

use ImageTransform\Image\GD as Image;
use ImageTransform\Transformation;
use ImageTransform\Transformation\Resize\GD as Resize;

$transformation = new Transformation(array(
  new Resize(),
));

$transformation->resize(100, 100, Resize::PROPORTIONAL | Resize::MINIMUM);

$filepath = __DIR__.'/images/green-hornet.jpg';
$image = new Image($filepath);
$transformation->process($image);
$image->saveAs(__DIR__.'/_resized-propmin.jpg');
