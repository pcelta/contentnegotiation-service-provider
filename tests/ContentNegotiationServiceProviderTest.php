<?php

namespace Dafiti\Silex;

use Silex\Application;
use Symfony\Component\HttpKernel\KernelEvents;

class ContentNegotiationServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldAddHeaderListenersWhenServiceProviderStartedWithSuccessfully()
    {
        $app = new Application();
        $config = [
            'available_accepts' => [
                'application/json',
                'application/xml'
            ],
            'default_accept'    => 'application/json'
        ];

        $countBefore = count($app['dispatcher']->getListeners(KernelEvents::REQUEST));

        $app->register(new ContentNegotiationServiceProvider($config));

        $listeners = $app['dispatcher']->getListeners(KernelEvents::REQUEST);
        $this->assertCount($countBefore + 1, $listeners);
    }

    public function testShouldAddResponseListenersWhenServiceProviderStartedWithSuccessfully()
    {
        $app = new Application();
        $config = [
            'available_accepts' => [
                'application/json',
                'application/xml'
            ],
            'default_accept'    => 'application/json'
        ];

        $countBefore = count($app['dispatcher']->getListeners(KernelEvents::VIEW));

        $app->register(new ContentNegotiationServiceProvider($config));

        $listeners = $app['dispatcher']->getListeners(KernelEvents::VIEW);
        $this->assertCount($countBefore + 1, $listeners);
    }
}