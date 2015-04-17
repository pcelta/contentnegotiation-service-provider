<?php

namespace Dafiti\Silex;

class Response
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var mixed
     */
    private $content;

    /**
     * @param $statusCode
     * @param $content
     */
    public function __construct($statusCode = 200, $content = null)
    {
        $this->setStatusCode($statusCode);
        $this->setContent($content);
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        if (!array_key_exists($statusCode, \Symfony\Component\HttpFoundation\Response::$statusTexts)) {
            $errorMessage = sprintf('Status code %s does not exist', $statusCode);
            throw new \InvalidArgumentException($errorMessage);
        }

        $this->statusCode = $statusCode;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}
