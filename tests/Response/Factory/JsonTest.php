<?php

use Symfony\Component\HttpFoundation;
use Dafiti\Silex\Response\Factory;

class JsonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider errorResponseProvider
     */
    public function testCreateShouldReturnJsonResponseWithErrorContent(\Dafiti\Silex\Response $controllerResponse, $errorMessage)
    {
        $expectedStatusCode = $controllerResponse->getStatusCode();
        $expectedContent = json_encode(['message' => $errorMessage]);

        $jsonFactory = new Factory\Json(Factory\Json::CONTENT_TYPE);
        $result = $jsonFactory->create($controllerResponse);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $result);
        $this->assertEquals($expectedStatusCode, $result->getStatusCode());
        $this->assertEquals($expectedContent, $result->getContent());
    }

    /**
     * @return array
     */
    public static function errorResponseProvider()
    {
        return [
            [new \Dafiti\Silex\Response(HttpFoundation\Response::HTTP_NOT_ACCEPTABLE), 'Accept Type Not Acceptable'],
            [new \Dafiti\Silex\Response(HttpFoundation\Response::HTTP_NOT_FOUND), 'Resource Not Found'],
        ];
    }

    public function testCreateShouldReturnJsonResponseWithEmptyContentWhenHasNotContent()
    {
        $expectedStatusCode = HttpFoundation\Response::HTTP_OK;
        $controllerResponse = new \Dafiti\Silex\Response();
        $jsonFactory = new Factory(Factory\Json::CONTENT_TYPE);
        $result = $jsonFactory->create($controllerResponse);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $result);
        $this->assertEquals($expectedStatusCode, $result->getStatusCode());
        $this->assertequals('[]', $result->getContent());
    }

    public function testCreateShouldReturnJsonResponseWithTransformedContentWhenContentIsNotArray()
    {
        $contentMessage = 'CONTENT FROM CONTROLLER';
        $expectedStatusCode = HttpFoundation\Response::HTTP_OK;
        $expectedContent = json_encode([$contentMessage]);

        $controllerResponse = new \Dafiti\Silex\Response($expectedStatusCode, $contentMessage);
        $jsonFactory = new Factory(Factory\Json::CONTENT_TYPE);

        $result = $jsonFactory->create($controllerResponse);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $result);
        $this->assertEquals($expectedStatusCode, $result->getStatusCode());
        $this->assertequals($expectedContent, $result->getContent());
    }

    public function testCreateShouldReturnJsonResponseWithContentWhenContentIsArray()
    {
        $content = ['content' => 'CONTENT FROM CONTROLLER'];
        $expectedStatusCode = HttpFoundation\Response::HTTP_OK;
        $expectedContent = json_encode($content);

        $controllerResponse = new \Dafiti\Silex\Response($expectedStatusCode, $content);
        $jsonFactory = new Factory(Factory\Json::CONTENT_TYPE);

        $result = $jsonFactory->create($controllerResponse);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $result);
        $this->assertEquals($expectedStatusCode, $result->getStatusCode());
        $this->assertequals($expectedContent, $result->getContent());
    }
}
