<?php

namespace ImageTransform\Transformation;

abstract class Transformation
{
  final public function execute(\Symfony\Component\EventDispatcher\Event $event)
  {
    $method = $event->get('method');

    if(method_exists($this, $method))
    {
      $event->setReturnValue($this->$method($event->get('arguments')));
      return true;
    }

    return false;
  }
}
