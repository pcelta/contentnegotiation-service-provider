<?php

namespace Dafiti\Silex;

use Silex\ServiceProviderInterface;
use Silex\Application;
use Dafiti\Silex\Listener\Header as HeaderListener;
use Dafiti\Silex\Listener\Response as ResponseListener;

class ContentNegotiationServiceProvider implements ServiceProviderInterface
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function register(Application $app)
    {
        $app['dispatcher']->addSubscriber(HeaderListener::create($this->config));
        $app['dispatcher']->addSubscriber(new ResponseListener());
    }

    public function boot(Application $app)
    {
    }
}
