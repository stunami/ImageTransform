<?php
require_once dirname(__FILE__) . '/Autoloader.php';
ImageTransform_Autoloader::register();


/*
$original = 'C:\Dokumente und Einstellungen\All Users\Dokumente\Eigene Bilder\Beispielbilder\Wasserlilien.jpg';
$target = 'M:\Wasserlilien.jpg';

$adapter = ImageTransform_Adapter_Factory::createAdapter();
$image = new ImageTransform_Source($adapter, $original, 'image/jpeg');

$image->thumbnail(100, 100);
var_dump($image->transform());
var_dump($image->isTransformed());
$image->saveAs($target);

*/