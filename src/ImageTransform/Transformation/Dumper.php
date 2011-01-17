<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Transformation;

use ImageTransform\Transformation;

/**
 * Dumper class.
 *
 * Abstract Transformation class providing saving and output methods.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
abstract class Dumper extends Transformation
{
  public function flush($mimeType = false)
  {
    echo $this->doFlush($mimeType);
  }

  public function save($filepath = false)
  {
    $filepath = $filepath ? $filepath : $this->image->get('image.filepath');

    if (false === $filepath)
    {
      throw new \InvalidArgumentException('No filepath set on image! Use saveAs() instead.');
    }

    file_put_contents($filepath, $this->doFlush());
  }

  abstract protected function doFlush($mimeType = false);
}
