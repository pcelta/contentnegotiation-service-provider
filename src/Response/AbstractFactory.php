<?php

namespace Dafiti\Silex\Response;

use Symfony\Component\HttpFoundation;

abstract class AbstractFactory
{
    /**
     * @var array
     */
    public $errorMessages = [
        HttpFoundation\Response::HTTP_NOT_ACCEPTABLE   => 'Accept Type Not Acceptable',
        HttpFoundation\Response::HTTP_NOT_FOUND        => 'Resource Not Found',
    ];

    /**
     * @var string
     */
    protected $contentType;

    /**
     * @param string $contentType
     */
    public function __construct($contentType)
    {
        $this->contentType = $contentType;
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
}
