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

$transformation->resize(100, 100, Resize::PROPORTIONAL | Resize::MINIMUM);

$files = glob(__DIR__.'/images/*.jpg');
foreach($files as $filepath)
{
  $_transformation = clone $transformation;
  $_transformation->save(dirname($filepath).'/_resized-batch-'.basename($filepath));
  $_transformation(new Image($filepath));
}
