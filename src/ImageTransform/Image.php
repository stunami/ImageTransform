<?php

namespace ImageTransform;

require_once __DIR__.'/../vendor/Symfony/Component/HttpFoundation/UniversalClassLoader.php';

use Symfony\Component\HttpFoundation\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespace('ImageTransform', __DIR__.'/..');
$loader->register();

use ImageTransform\Transformation\Exception\TransformationNotFoundException;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Image
{
  const EVENT_TRANSFORMATION = 'image_transform.transformation';

  protected $dispatcher;

  public function __construct($dispatcher)
  {
    $this->dispatcher = $dispatcher;
  }

  public function __call($method, $arguments)
  {
    $event = new Event($this, self::EVENT_TRANSFORMATION, array('method' => $method, 'arguments' => $arguments));

    $this->dispatcher->notifyUntil($event);

    if ($event->isProcessed())
    {
      return $event->getReturnValue();
    }

    throw new TransformationNotFoundException($method . ' could not be found!');
  }
}
