# ImageTransform

Rewrite branch of the standalone PHP image manipulation library.

## Adding a new transformation

namespace ImageTransform\Transformation;

use ImageTransform\Transformation\Transformation;

class Resize extends Transformation
{
  public function resize($width, $height)
  {
    // do something with $this->image
    return $this->image;
  }
}

## Registering the new transformation

    $resize = new Resize();
    $dispatcher = new EventDispatcher();
    $dispatcher->connect(Image::EVENT_TRANSFORMATION, array($resize, 'execute'));

## Executing the new transformation

    $image = new Image();
    $image->resize(120, 160);
