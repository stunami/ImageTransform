<?php
class ImageTransform_Config extends ImageTransform_Config_Abstract
{
  public function __construct(array $config)
  {
    if (isset($config['default_adapter']))
    {
      $this->defaultAdapter = $config['default_adapter'];
    }
    if (isset($config['default_image']))
    {
      $this->defaultImage = $config['default_image'];
    }
    if (isset($config['font_dir']))
    {
      $this->fontDir = $config['font_dir'];
    }
    if (isset($config['mime_type_auto_detect']))
    {
      $this->mimeAutoDetection = (bool) $config['mime_type_auto_detect'];
    }
    if (isset($config['mime_type_library']))
    {
      $this->mimeAutoDetectionLib = $config['mime_type_library'];
    }
  }
}