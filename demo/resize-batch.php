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

$files = glob(__DIR__.'/images/*.jpg');
foreach($files as $filepath)
{
  $image = new Image($filepath);
  $transformer($image);
  $image->saveAs(__DIR__.'/_resized-batch-'.basename($filepath));
}
