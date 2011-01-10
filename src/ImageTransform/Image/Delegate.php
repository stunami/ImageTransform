<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Image;

/**
 * Delegate class.
 *
 * Deriving classes provide callback methods to the fluent API of Image.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
abstract class Delegate
{
  /**
   * @var \ImageTransform\Image $image Instance of the Image this Delegate is providing callbacks for
   */
  protected $image;

  /**
   * C'tor
   *
   * @param \ImageTransform\Image $image Image instance to perform operations on
   */
  public function __construct(\ImageTransform\Image $image)
  {
    $this->image = $image;
  }
}
