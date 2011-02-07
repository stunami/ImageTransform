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

$files = glob(__DIR__.'/images/*.jpg');
foreach($files as $filepath)
{
  $image = new Image($filepath);
  $transformation($image);
  $image->saveAs(__DIR__.'/_resized-batch-'.basename($filepath));
}
