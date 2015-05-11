<?php

namespace Dafiti\Silex\Response;

use Dafiti\Silex\Response\Factory\Factorable;
use Dafiti\Silex\Response\Factory\Json;
use Symfony\Component\HttpFoundation;

class Factory implements Factorable
{
    /**
     * @var Factorable
     */
    private $factory;

    /**
     * @var array
     */
    private static $factoriesMap = [
        Json::CONTENT_TYPE => 'Json',
    ];

    /**
     * @var string
     */
    private static $factoriesNamespace = '\Dafiti\Silex\Response\Factory\\';

    /**
     * @param string $contentType
     */
    public function __construct($contentType)
    {
        $this->initFactory($contentType);
    }

    /**
     * @param string $contentType
     */
    private function initFactory($contentType)
    {
        foreach (self::$factoriesMap as $type => $factoryName) {
            $matched = is_int(strpos($contentType, $type));
            if ($matched) {
                $class = self::$factoriesNamespace.$factoryName;
                $this->factory = new $class($contentType);
            }
        }
    }

    /**
     * @param \Dafiti\Silex\Response $controllerResponse
     *
     * @return HttpFoundation\Response
     */
    public function create(\Dafiti\Silex\Response $controllerResponse)
    {
        $response = $this->factory->create($controllerResponse);

        return $response;
    }
}
