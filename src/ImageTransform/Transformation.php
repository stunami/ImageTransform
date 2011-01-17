<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform;

use ImageTransform\Image;

/**
 * Transformation class.
 *
 * Deriving classes provide callback methods to the fluent API of Transformer.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
abstract class Transformation
{
  /**
   * @var \ImageTransform\Image $image Instance of the Image this Transformation is providing callbacks for
   */
  protected $image;

  /**
   * C'tor
   *
   * @param \ImageTransform\Image $image Image instance to perform operations on
   */
  public function __construct(Image $image)
  {
    $this->image = $image;
  }
}
