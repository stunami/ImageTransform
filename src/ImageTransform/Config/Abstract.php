<?php
abstract class ImageTransform_Config_Abstract implements ImageTransform_Config_Interface
{
  protected $defaultAdapter = 'Gd';
  protected $defaultImage = array(
    'mime_type' => 'image/png',
    'filename' => 'Untitled.png',
    'width' => 100,
    'height' => 100,
    'color' => '#FFFFFF'
  );
  protected $fontDir = '/usr/share/fonts/truetype/msttcorefonts';
  protected $mimeAutoDetection = true;
  protected $mimeAutoDetectionLib = 'gd_mime_type'; // gd_mime_type (GD), Fileinfo (PECL), MIME_Type (PEAR)

  abstract public function __get($name)
  {
    return $this->$name;
  }

  abstract public function __set($name, $value)
  {
    $this->$name = $value;
  }
}