<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Image\Dumper;

use ImageTransform\Image\Dumper;
use ImageTransform\Image\Exception\MimeTypeNotSupportedException;

/**
 * GD Dumper
 *
 * Uses GD to save or dump images.
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class GD extends Dumper
{
  protected function dump($mimeType = false)
  {
    if ('GD' != ($api = $this->image->get('core.image_api')))
    {
      throw new \UnexpectedValueException('Wrong image API ('.$api.')!');
    }

    if (!($resource = $this->image->get('image.resource')))
    {
      throw new \UnexpectedValueException('Could not read resource!');
    }

    ob_start();

    $mimeType = $mimeType ? $mimeType : $this->image->get('image.mime_type');

    switch($mimeType)
    {
      case 'image/gif':
        imagegif($resource);
        break;
      case 'image/jpg':
      case 'image/jpeg':
        imagejpeg($resource);
        break;
      case 'image/png':
        imagepng($resource);
        break;
      default:
        throw new MimeTypeNotSupportedException('Images of type "'.$mimeType.'" are not supported!');
    }

    $dump = ob_get_contents();
    ob_end_clean();

    return $dump;
  }
}
