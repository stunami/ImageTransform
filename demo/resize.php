<?php

namespace ImageTransform\Demo;

require __DIR__.'/../src/autoload.php';

use ImageTransform\Image\GD as Image;
use ImageTransform\Transformer;
use ImageTransform\Transformation\Resize\GD as Resize;

$transformer = new Transformer(array(
  new Resize(),
));

$transformer->resize(100, 100, Resize::PROPORTIONAL | Resize::MINIMUM);

$filepath = __DIR__.'/images/green-hornet.jpg';
$image = new Image($filepath);
$transformer->process($image);
$image->saveAs(__DIR__.'/_resized-propmin.jpg');
