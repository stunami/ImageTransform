<?php

require_once __DIR__.'/../src/vendor/Symfony/Component/HttpFoundation/UniversalClassLoader.php';

use Symfony\Component\HttpFoundation\UniversalClassLoader;

echo __DIR__.'/../src/ImageTransform'.PHP_EOL;
$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
  'ImageTransform' => __DIR__.'/../src',
  'Symfony' => __DIR__.'/../src/vendor'
));
$loader->register();
