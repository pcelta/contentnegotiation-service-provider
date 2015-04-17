<?php

namespace Dafiti\Silex\Exception;

class AcceptNotAllowed extends \Exception
{
    public function __construct(array $accepts)
    {
        $serializedAccepts = implode(', ', $accepts);
        $message = sprintf('Accept(s) %s Not Allowed(s)', $serializedAccepts);
        parent::__construct($message);
    }
}
