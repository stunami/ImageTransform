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
 * Loader class.
 *
 * Abstract Transformation class providing creating and loading methods.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
abstract class Loader extends Transformation
{
  public function create($width, $height)
  {
    $this->setMeta($this->doCreate($width, $height));
  }

  public function open($filepath)
  {
    $this->image->set('image.filepath', $filepath);
    $this->setMeta($this->doOpen($filepath));
  }

  abstract protected function doOpen($filepath);
  abstract protected function doCreate($width, $height);

  protected function setMeta($data)
  {
    $this->image->set('image.resource',  $data[0]);
    $this->image->set('image.width',     $data[1]);
    $this->image->set('image.height',    $data[2]);
    $this->image->set('image.mime_type', $data[3]);
  }
}
