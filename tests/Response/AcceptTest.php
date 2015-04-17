<?php


class AcceptTest extends PHPUnit_Framework_TestCase
{
    public function testGetDefaultShouldReturnAttributeWithoutChange()
    {
        $expectedDefaultAccept = 'application/json';
        $availblesAccepts = ['application/json'];
        $accept = new \Dafiti\Silex\Response\Accept($expectedDefaultAccept, $availblesAccepts);
        $result = $accept->getDefault();

        $this->assertEquals($expectedDefaultAccept, $result);
    }

    public function testGetBestShouldReturnDefatulAcceptWhenEmptyAccepts()
    {
        $expectedDefaultAccept = 'default';
        $availblesAccepts = [];
        $accept = new \Dafiti\Silex\Response\Accept($expectedDefaultAccept, $availblesAccepts);
        $result = $accept->getBest([]);

        $this->assertEquals($expectedDefaultAccept, $result);
    }

    public function testGetBestShouldReturnFirstAvailableAccept()
    {
        $expectedAccept = 'application/xhtml';
        $defaultAccept = 'application/json';
        $availblesAccepts = ['application/xml', 'application/json', $expectedAccept];

        $accept = new \Dafiti\Silex\Response\Accept($defaultAccept, $availblesAccepts);

        $result = $accept->getBest(['text/html', $expectedAccept]);

        $this->assertEquals($expectedAccept, $result);
    }

    /**
     * @expectedException \Dafiti\Silex\Exception\AcceptNotAllowed
     */
    public function testGetBestThrowAcceptNotAllowedWhenAcceptNotInAvailblesAccepts()
    {
        $defaultAccept = 'application/json';
        $availblesAccepts = ['application/xml', 'application/json'];
        $accept = new \Dafiti\Silex\Response\Accept($defaultAccept, $availblesAccepts);

        $accept->getBest(['text/html']);
    }

    public function testHasAllowedShouldReturnFalseWhenAcceptsNotAreInAvailblesAccepts()
    {
        $defaultAccept = 'application/json';
        $availblesAccepts = ['application/xml', 'application/json'];
        $accept = new \Dafiti\Silex\Response\Accept($defaultAccept, $availblesAccepts);

        $result = $accept->hasAllowed(['text/html']);

        $this->assertFalse($result);
    }

    public function testHasAllowedShouldReturnTrueWhenAcceptsAreInAvailblesAccepts()
    {
        $defaultAccept = 'application/json';
        $availblesAccepts = ['application/xml', 'application/json'];
        $accept = new \Dafiti\Silex\Response\Accept($defaultAccept, $availblesAccepts);

        $result = $accept->hasAllowed(['application/xml']);

        $this->assertTrue($result);
    }
}
