<?php

namespace Dafiti\Silex\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Dafiti\Silex\Response\Factory;

class Response implements EventSubscriberInterface
{
    /**
     * @param GetResponseForControllerResultEvent $event
     *
     * @return GetResponseForControllerResultEvent
     */
    public function onKernelResponse(GetResponseForControllerResultEvent $event)
    {
        if ($event->hasResponse()) {
            return $event;
        }

        $accept = $event->getRequest()->get('_accept');

        $responseFactory = new Factory($accept);
        $response = $responseFactory->create($event->getControllerResult());

        $event->setResponse($response);

        return $event;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onKernelResponse', 100],
        ];
    }
}
