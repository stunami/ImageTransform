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

$files = glob(__DIR__.'/images/*.jpg');
foreach($files as $filepath)
{
  $image = new Image($filepath);
  $transformer($image);
  $image->saveAs(__DIR__.'/_resized-batch-'.basename($filepath));
}
