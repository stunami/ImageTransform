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

$batch = function($filepath) use ($image)
{
  $filename = basename($filepath);
  $dirname  = dirname($filepath);

  $image->open($filepath)
        ->resize(100, 100, Resize::PROPORTIONAL)
        ->save($dirname.'/_resized-prop-'.$filename);
};

$files = glob(__DIR__.'/images/*.jpg');
foreach($files as $filepath)
{
  $batch($filepath);
}
