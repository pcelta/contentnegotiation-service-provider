<?php

namespace Dafiti\Silex\Listener;

use Symfony\Component\HttpFoundation;

class HeaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Dafiti\Silex\Listener\Header::getSubscribedEvents
     */
    public function testSubscribedEvents()
    {
        $expectedEvent = [
            \Symfony\Component\HttpKernel\KernelEvents::REQUEST => ['onKernelRequest', 100],
        ];

        $result = Header::getSubscribedEvents();

        $this->assertEquals($expectedEvent, $result);
    }

    /**
     * @covers Dafiti\Silex\Listener\Header::create
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateThrowInvalidArgumentExceptionWhenAvailableAcceptsNotDefinedInConfig()
    {
        $config = [];
        $config['available_accepts'] = null;

        Header::create($config);
    }

    /**
     * @covers Dafiti\Silex\Listener\Header::create
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateThrowInvalidArgumentExceptionWhenDefaultAcceptNotDefinedInConfig()
    {
        $config = [];
        $config['available_accepts'] = [];
        $config['default_accept'] = null;

        Header::create($config);
    }

    /**
     * @covers Dafiti\Silex\Listener\Header::create
     */
    public function testCreateShouldReturnHeaderInstance()
    {
        $config = [];
        $config['available_accepts'] = [];
        $config['default_accept'] = 'application/json';

        $result = Header::create($config);

        $this->assertInstanceOf('Dafiti\Silex\Listener\Header', $result);
    }

    /**
     * @covers Dafiti\Silex\Listener\Header::onKernelRequest
     * @covers Dafiti\Silex\Listener\Header::setNotAcceptableError
     */
    public function testCreateShouldDefineNotAcceptableResponseWhenAcceptNotAllowed()
    {
        $expectedStatusCode = HttpFoundation\Response::HTTP_NOT_ACCEPTABLE;

        $mockedKernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $request = new HttpFoundation\Request();
        $request->headers->set('Accept', 'text/json');
        $requestType = \Symfony\Component\HttpKernel\HttpKernelInterface::MASTER_REQUEST;
        $event = new \Symfony\Component\HttpKernel\Event\GetResponseEvent($mockedKernel, $request, $requestType);

        $defaultAccept = 'application/json';
        $availablesAccepts = ['application/json'];
        $accept = new \Dafiti\Silex\Response\Accept($defaultAccept, $availablesAccepts);

        $listener = new Header($accept);
        $result = $listener->onKernelRequest($event);

        $this->assertTrue($result->hasResponse());
        $this->assertEquals($expectedStatusCode, $result->getResponse()->getStatusCode());
    }

    /**
     * @covers Dafiti\Silex\Listener\Header::onKernelRequest
     * @covers Dafiti\Silex\Listener\Header::setNotAcceptableError
     */
    public function testCreateShouldDefineNotAcceptableResponseWhenAcceptEmptyOrNull()
    {
        $expectedStatusCode = HttpFoundation\Response::HTTP_NOT_ACCEPTABLE;

        $mockedKernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $request = new HttpFoundation\Request();
        $request->headers->set('Accept', null);
        $requestType = \Symfony\Component\HttpKernel\HttpKernelInterface::MASTER_REQUEST;
        $event = new \Symfony\Component\HttpKernel\Event\GetResponseEvent($mockedKernel, $request, $requestType);

        $defaultAccept = 'application/json';
        $availablesAccepts = ['application/json'];
        $accept = new \Dafiti\Silex\Response\Accept($defaultAccept, $availablesAccepts);

        $listener = new Header($accept);
        $result = $listener->onKernelRequest($event);

        $this->assertTrue($result->hasResponse());
        $this->assertEquals($expectedStatusCode, $result->getResponse()->getStatusCode());
    }

    /**
     * @covers Dafiti\Silex\Listener\Header::onKernelRequest
     */
    public function testCreateShouldDefineAcceptIntoRequestParamsWhenAcceptAllowed()
    {
        $expectedAccept = 'application/json';
        $mockedKernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $request = new HttpFoundation\Request();
        $request->headers->set('Accept', $expectedAccept);
        $requestType = \Symfony\Component\HttpKernel\HttpKernelInterface::MASTER_REQUEST;
        $event = new \Symfony\Component\HttpKernel\Event\GetResponseEvent($mockedKernel, $request, $requestType);

        $defaultAccept = 'application/json';
        $availablesAccepts = ['application/json'];
        $accept = new \Dafiti\Silex\Response\Accept($defaultAccept, $availablesAccepts);

        $listener = new Header($accept);
        $result = $listener->onKernelRequest($event);

        $this->assertFalse($result->hasResponse());
        $this->assertEquals($expectedAccept, $result->getRequest()->get('_accept'));
    }
}
