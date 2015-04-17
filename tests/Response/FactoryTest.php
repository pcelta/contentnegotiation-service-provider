<?php

use Symfony\Component\HttpFoundation;
use Dafiti\Silex\Response\Factory;

class FactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCreateNotAcceptableShouldReturnResponse406()
    {
        $expectedStatusCode = HttpFoundation\Response::HTTP_NOT_ACCEPTABLE;
        $controllerResponse = new \Dafiti\Silex\Response($expectedStatusCode);

        $factory = new Factory('application/json');
        $result = $factory->create($controllerResponse);

        $this->assertEquals($expectedStatusCode, $result->getStatusCode());
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $result);
    }
}
