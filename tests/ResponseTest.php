<?php

namespace Dafiti\Silex;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidStatusCodesProvider
     */
    public function testConstructThrowInvalidArgumentWhenStatusCodeArentInHttpFoundation($invalidStatusCode)
    {
        new Response($invalidStatusCode);
    }

    public static function invalidStatusCodesProvider()
    {
        return [
            [0],
            [999],
            [1000],
            [1],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidStatusCodesProvider
     */
    public function testSetStatusThrowInvalidArgumentWhenStatusCodeArentInHttpFoundation($invalidStatusCode)
    {
        $response = new Response();
        $response->setStatusCode($invalidStatusCode);
    }
}
