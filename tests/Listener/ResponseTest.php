<?php

use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public function testSubscribedEvents()
    {
        $expectedEvents = [
            HttpKernel\KernelEvents::VIEW => ['onKernelResponse', 100],
        ];

        $result = \Dafiti\Silex\Listener\Response::getSubscribedEvents();
        $this->assertEquals($expectedEvents, $result);
    }

    public function testOnKernelResponseShouldNotChangeResponseWhenResponseAlreadyExistsInEvent()
    {
        $mockedKernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $request = new HttpFoundation\Request(['_accept' => 'application/json+v1']);

        $requestType = HttpKernel\HttpKernelInterface::MASTER_REQUEST;
        $event = new HttpKernel\Event\GetResponseForControllerResultEvent($mockedKernel, $request, $requestType, null);
        $expectedResponse = new HttpFoundation\Response();
        $event->setResponse($expectedResponse);

        $listener = new \Dafiti\Silex\Listener\Response();
        $result = $listener->onKernelResponse($event);

        $this->assertSame($expectedResponse, $result->getResponse());
    }
}
