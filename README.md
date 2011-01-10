# ImageTransform

Rewrite branch of the standalone PHP image manipulation library.

## Adding a new transformation

namespace ImageTransform\Transformation;

use ImageTransform\Image\Delegate;

class Resize extends Delegate
{
  public function resize($width, $height)
  {
    // do something with $this->image
    return $this->image;
  }
}

## Registering the new transformation

    $transformationClasses = array(
      'ImageTransform\Transformation\Resize',
      ...
    );
    $image = new Image($transformationClasses);

## Executing the new transformation

    $image = new Image();
    $image->resize(120, 160);
