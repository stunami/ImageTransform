<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__.'/vendor/Symfony/Component/HttpFoundation/UniversalClassLoader.php';

use Symfony\Component\HttpFoundation\UniversalClassLoader;

/**
 * This file provides automatic class loading.
 *
 * To use it you have to require it once in your code.
 * Afterwards you can simply use all classes in the namespace \ImageTransform.
 * Of course you can use your own auto loading.
 */

$loader = new UniversalClassLoader();
$loader->registerNamespace('ImageTransform', __DIR__.'/../src');

$loader->register();
