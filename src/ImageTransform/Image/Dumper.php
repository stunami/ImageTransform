<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Image;

use ImageTransform\Image\Delegate;

/**
 * Dumper class.
 *
 * Abstract Delegate class providing saving and output methods.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
abstract class Dumper extends Delegate
{
  public function flush($mimeType = false)
  {
    echo $this->doFlush($mimeType);

    return $this->image;
  }

  public function save($filepath = false)
  {
    $filepath = $filepath ? $filepath : $this->image->get('image.filepath');

    if (false === $filepath)
    {
      throw new \InvalidArgumentException('No filepath set on image! Use saveAs() instead.');
    }

    file_put_contents($filepath, $this->doFlush());

    return $this->image;
  }

  abstract protected function doFlush($mimeType = false);
}
