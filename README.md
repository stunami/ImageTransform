# ImageTransform

> *This is a rewrite of the standalone PHP image manipulation library ImageTransform for PHP 5.3.x.*

The aim of ImageTransformis take the pain out of image manipulating in PHP. ImageTransform is great for but not limited to common tasks like creating thumbnails, adding text to dynamic images or watermarking.

ImageTransform works by applying one or more "transformations" to the image.  A transformation can be a simple action like resize, thumbnail or mirror or more complex like an overlay (watermarks) or pixelate.

Multiple tranformations can be easily applied by chaining the transform calls as seen below. It is also very easy to extend and create your own transforms, see "Writing your own transformation" for an example. 

*Example 1. Simple chaining of transforms*

Load an image, resize it to 80 x 60 pixels.

    $image->from('image1.jpg')
      ->resize(80, 60)
      ->save();

## Writing your own transformation

In ImageTransform everything is a `Delegate` - a class whose public methods are made available on the `Image` instance.

Writing a `Delegate` is easy. You only have to extend from `Delegate` and implement one or more public methods.

*Example 2. Simple implementation of a resize transformation*

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

> Please note that you must return `$this->image` to preserve the fluid API.

To make this new transformation available on the `Image` instances you need to pass the name of your `Delegate` class to `Image::__construct()`.

*Example 3. Registering your transformation from example 2.*

    $transformationClasses = array(
      'ImageTransform\Transformation\Resize',
      ...
    );
    $image = new Image($transformationClasses);

Now your transformation is available on any `Image` instance and can be called like this.

    $image = new Image();
    $image->resize(120, 160);
