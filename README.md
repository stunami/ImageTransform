# ImageTransform

> *This is a rewrite of the standalone PHP image manipulation library ImageTransform for PHP 5.3.x.*

The aim of ImageTransform is take the pain out of image manipulating in PHP. ImageTransform is great for but not limited to common tasks like creating thumbnails, adding text to dynamic images or watermarking.

ImageTransform works by applying one or more "transformations" to the image.  A transformation can be a simple action like resize, thumbnail or mirror or more complex like an overlay (watermarks) or pixelate.

Multiple tranformations can be easily applied by chaining the transform calls as seen below. It is also very easy to extend and create your own transforms, see "Writing your own transformation" for an example. 

*Example 1. Simple chaining of transforms*

Load an image, resize it to 80 x 60 pixels.

    $image = new Image('image1.jpg');

    $transformer->resize(80, 60)
                ->process($image);

    $image->save();

Methods of `ImageTransform\Transformer` are added via so called `Transformations`.

