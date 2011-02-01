<?php

namespace ImageTransform\Demo;

require __DIR__.'/../src/autoload.php';

use ImageTransform\Image;
use ImageTransform\FileAccessAdapter\GD as FileAccessAdapter;
use ImageTransform\Transformer;
use ImageTransform\Transformation\Resize;

$transformer = new Transformer(array(
  'ImageTransform\Transformation\Resize\GD',
));

Image::setFileAccessAdapter(new FileAccessAdapter());

$transformer->resize(100, 100, Resize::PROPORTIONAL | Resize::MINIMUM);

$filepath = __DIR__.'/images/green-hornet.jpg';
$image = new Image($filepath);
$transformer->process($image);
$image->saveAs(__DIR__.'/_resized-propmin.jpg');
