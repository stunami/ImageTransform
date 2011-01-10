<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Image\Loader;

use ImageTransform\Image\Loader;
use ImageTransform\Image\Exception\MimeTypeNotSupportedException;

/**
 * GD Loader
 *
 * Uses GD to load/create images.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class GD extends Loader
{
  public function __construct(\ImageTransform\Image $image)
  {
    parent::__construct($image);

    $this->image->set('core.image_api', 'GD');
  }

  protected function createImage($width, $height)
  {
    $resource = imagecreatetruecolor($width, $height);
    $this->setResource($resource);
    $this->setMimeType(false);
    $this->setDimensions($width, $height);
  }

  protected function loadImage($filepath)
  {
    if (!is_readable($filepath))
    {
      throw new \InvalidArgumentException('File "'.$filepath.'" not readable!');
    }

    $info = getimagesize($filepath);

    switch ($info['mime'])
    {
      case 'image/gif':
        $resource = imagecreatefromgif($filepath);
        break;
      case 'image/jpg':
      case 'image/jpeg':
        $resource = imagecreatefromjpeg($filepath);
        break;
      case 'image/png':
        $resource = imagecreatefrompng($filepath);
        break;
      default:
        throw new MimeTypeNotSupportedException('Images of type "'.$info['mime'].'" are not supported!');
    }

    $this->setResource($resource);
    $this->setMimeType($info['mime']);
    $this->setDimensions($info[0], $info[1]);
  }
}
