<?php

namespace Dafiti\Silex\Response\Factory;

use Dafiti\Silex\Response\AbstractFactory;
use Symfony\Component\HttpFoundation;

class Json extends AbstractFactory implements Factorable
{
    const CONTENT_TYPE = 'application/json';

    /**
     * @param \Dafiti\Silex\Response $controllerResponse
     *
     * @return HttpFoundation\Response
     */
    protected function transform(\Dafiti\Silex\Response $controllerResponse)
    {
        $response = new HttpFoundation\JsonResponse();
        $response->headers->add(
            ['Content-Type' => self::CONTENT_TYPE]
        );
        $response->setStatusCode($controllerResponse->getStatusCode());

        if ($this->hasError()) {
            $content = [
                'message' => $controllerResponse->getErrorMessage(),
            ];

            $response->setData($content);

            return $response;
        }

        $response->setStatusCode($controllerResponse->getStatusCode());
        $content = $this->getContent($controllerResponse);
        $response->setData($content);

        return $response;
    }

    /**
     * @param \Dafiti\Silex\Response $controllerResponse
     *
     * @return array
     */
    private function getContent(\Dafiti\Silex\Response $controllerResponse)
    {
        $content = $controllerResponse->getContent();
        if (is_null($content)) {
            return [];
        }

        if (!is_array($content)) {
            return [$content];
        }

        return $content;
    }
}
