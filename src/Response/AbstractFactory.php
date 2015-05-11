<?php

namespace Dafiti\Silex\Response;

use Dafiti\Silex\Exception\InvalidResponse;
use Symfony\Component\HttpFoundation;

abstract class AbstractFactory
{

    /**
     * @var string
     */
    protected $contentType;

    /**
     * @var bool
     */
    private $hasError;

    /**
     * @param string $contentType
     */
    public function __construct($contentType)
    {
        $this->contentType = $contentType;
        $this->hasError = false;
    }

    /**
     * @param int $statusCode
     *
     * @return bool
     */
    protected function isError($statusCode)
    {
        $successStatus = [
            HttpFoundation\Response::HTTP_OK,
            HttpFoundation\Response::HTTP_CREATED,
            HttpFoundation\Response::HTTP_ACCEPTED,
            HttpFoundation\Response::HTTP_NO_CONTENT,
        ];

        if (in_array($statusCode, $successStatus)) {
            return false;
        }

        return true;
    }

    /**
     * @param \Dafiti\Silex\Response $controllerResponse
     * @return HttpFoundation\Response
     * @throws InvalidResponse
     */
    public function create(\Dafiti\Silex\Response $controllerResponse)
    {
        $controllerResponse = $this->decorateControllerResponse($controllerResponse);

        $response = $this->transform($controllerResponse);

        if (!$response instanceof HttpFoundation\Response) {

            throw new InvalidResponse();
        }

        return $response;
    }

    /**
     * @param \Dafiti\Silex\Response $controllerResponse
     * @return \Dafiti\Silex\Response
     */
    private function decorateControllerResponse(\Dafiti\Silex\Response $controllerResponse)
    {
        if ($this->isError($controllerResponse->getStatusCode())) {
            $this->hasError = true;

            return $this->decorateErrorMessage($controllerResponse);
        }

        return $controllerResponse;
    }

    /**
     * @param \Dafiti\Silex\Response $controllerResponse
     * @return \Dafiti\Silex\Response
     */
    private function decorateErrorMessage(\Dafiti\Silex\Response $controllerResponse)
    {
        $message = HttpFoundation\Response::$statusTexts[$controllerResponse->getStatusCode()];

        if (!is_null($controllerResponse->getErrorMessage())) {
            $message = $controllerResponse->getErrorMessage();
        }

        $controllerResponse->setErrorMessage($message);

        return $controllerResponse;
    }

    /**
     * @return bool
     */
    protected function hasError()
    {
        return $this->hasError;
    }

    /**
     * @param \Dafiti\Silex\Response $controllerResponse $response
     * @return HttpFoundation\Response
     */
    abstract protected function transform(\Dafiti\Silex\Response $controllerResponse);
}
