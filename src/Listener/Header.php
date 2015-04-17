<?php

namespace Dafiti\Silex\Listener;

use Dafiti\Silex\Response\Accept;
use Dafiti\Silex\Response\Factory as ResponseFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class Header implements EventSubscriberInterface
{
    /**
     * @var Accept
     */
    private $accept;

    /**
     * @param Accept $accept
     */
    public function __construct(Accept $accept)
    {
        $this->accept = $accept;
    }

    /**
     * @param GetResponseEvent $event
     *
     * @return GetResponseEvent
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->getRequest()->headers->get('Accept')) {
            $this->setNotAcceptableError($event);

            return $event;
        }

        $raw_accepts = explode(',', $event->getRequest()->headers->get('Accept'));
        $accepts = array_map('trim', $raw_accepts);

        if (!$this->accept->hasAllowed($accepts)) {
            $this->setNotAcceptableError($event);

            return $event;
        }

        $accept = $this->accept->getBest($accepts);
        $event->getRequest()->request->set('_accept', $accept);

        return $event;
    }

    private function setNotAcceptableError(GetResponseEvent $event)
    {
        $responseFactory = new ResponseFactory($this->accept->getDefault());
        $catalogResponse = new \Dafiti\Silex\Response(HttpFoundation\Response::HTTP_NOT_ACCEPTABLE);
        $response = $responseFactory->create($catalogResponse);
        $event->setResponse($response);
        $event->stopPropagation();
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 100],
        ];
    }

    /**
     * @param array $config
     *
     * @return ContentNegotiationHeader
     *
     * @throws \InvalidArgumentException
     */
    public static function create(array $config)
    {
        $availableAccepts = $config['available_accepts'];

        if (is_null($availableAccepts)) {
            throw new \InvalidArgumentException('available_accepts');
        }

        $defaultAccept = $config['default_accept'];
        if (is_null($defaultAccept)) {
            throw new \InvalidArgumentException('default_accept');
        }

        $accept = new Accept($defaultAccept, $availableAccepts);

        return new self($accept);
    }
}
