<?php

namespace Dafiti\Silex\Exception;

class InvalidResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers  \Dafiti\Silex\Exception\InvalidResponse::__construct
     * @expectedException \Dafiti\Silex\Exception\InvalidResponse
     * @expectedExceptionMessage The Returned Value Is Not A Symfony\Component\HttpFoundation\Response Instance Or Child From It
     */
    public function testShouldReturnExpectedMessage()
    {
        throw new InvalidResponse();
    }
}