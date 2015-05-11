<?php

namespace Dafiti\Silex\Exception;

class InvalidResponse extends \Exception
{
    public function __construct()
    {
        $message = 'The Returned Value Is Not A Symfony\Component\HttpFoundation\Response Instance Or Child From It';
        parent::__construct($message);
    }
}
