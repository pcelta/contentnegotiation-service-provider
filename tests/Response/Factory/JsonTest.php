<?php

use Symfony\Component\HttpFoundation;
use Dafiti\Silex\Response\Factory;

class JsonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider errorResponseProvider
     * @covers \Dafiti\Silex\Response\Factory\Json::transform
     */
    public function testCreateShouldReturnJsonResponseWithErrorContentAndDefaultMessage(\Dafiti\Silex\Response $controllerResponse, $errorMessage)
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
            [new \Dafiti\Silex\Response(HttpFoundation\Response::HTTP_NOT_ACCEPTABLE), 'Not Acceptable'],
            [new \Dafiti\Silex\Response(HttpFoundation\Response::HTTP_NOT_FOUND), 'Not Found'],
        ];
    }


    /**
     * @dataProvider errorResponseProvider
     * @covers \Dafiti\Silex\Response\Factory\Json::transform
     */
    public function testCreateShouldReturnJsonResponseWithErrorContentAndSettedMessage(\Dafiti\Silex\Response $controllerResponse, $errorMessage)
    {
        $controllerResponse = new \Dafiti\Silex\Response(HttpFoundation\Response::HTTP_NOT_ACCEPTABLE, null, 'My Message');

        $expectedStatusCode = $controllerResponse->getStatusCode();
        $expectedContent = json_encode(['message' => 'My Message']);

        $jsonFactory = new Factory\Json(Factory\Json::CONTENT_TYPE);
        $result = $jsonFactory->create($controllerResponse);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $result);
        $this->assertEquals($expectedStatusCode, $result->getStatusCode());
        $this->assertEquals($expectedContent, $result->getContent());
    }

    /**
     * @covers \Dafiti\Silex\Response\Factory\Json::transform
     * @covers \Dafiti\Silex\Response\Factory\Json::getContent
     */
    public function testCreateShouldReturnJsonResponseWithEmptyContentWhenHasNotContent()
    {
        $expectedStatusCode = HttpFoundation\Response::HTTP_OK;
        $controllerResponse = new \Dafiti\Silex\Response();
        $jsonFactory = new Factory\Json(Factory\Json::CONTENT_TYPE);
        $result = $jsonFactory->create($controllerResponse);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $result);
        $this->assertEquals($expectedStatusCode, $result->getStatusCode());
        $this->assertequals('[]', $result->getContent());
        $this->assertTrue($result->headers->contains('Content-Type', Factory\Json::CONTENT_TYPE));
    }

    /**
     * @covers \Dafiti\Silex\Response\Factory\Json::transform
     * @covers \Dafiti\Silex\Response\Factory\Json::getContent
     */
    public function testCreateShouldReturnJsonResponseWithTransformedContentWhenContentIsNotArray()
    {
        $contentMessage = 'CONTENT FROM CONTROLLER';
        $expectedStatusCode = HttpFoundation\Response::HTTP_OK;
        $expectedContent = json_encode([$contentMessage]);

        $controllerResponse = new \Dafiti\Silex\Response($expectedStatusCode, $contentMessage);
        $jsonFactory = new Factory\Json(Factory\Json::CONTENT_TYPE);

        $result = $jsonFactory->create($controllerResponse);


        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $result);
        $this->assertEquals($expectedStatusCode, $result->getStatusCode());
        $this->assertequals($expectedContent, $result->getContent());
        $this->assertTrue($result->headers->contains('Content-Type', Factory\Json::CONTENT_TYPE));
    }

    /**
     * @covers \Dafiti\Silex\Response\Factory\Json::transform
     * @covers \Dafiti\Silex\Response\Factory\Json::getContent
     */
    public function testCreateShouldReturnJsonResponseWithContentWhenContentIsArray()
    {
        $content = ['content' => 'CONTENT FROM CONTROLLER'];
        $expectedStatusCode = HttpFoundation\Response::HTTP_OK;
        $expectedContent = json_encode($content);

        $controllerResponse = new \Dafiti\Silex\Response($expectedStatusCode, $content);
        $jsonFactory = new Factory\Json(Factory\Json::CONTENT_TYPE);

        $result = $jsonFactory->create($controllerResponse);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $result);
        $this->assertEquals($expectedStatusCode, $result->getStatusCode());
        $this->assertequals($expectedContent, $result->getContent());
        $this->assertTrue($result->headers->contains('Content-Type', Factory\Json::CONTENT_TYPE));
    }
}
