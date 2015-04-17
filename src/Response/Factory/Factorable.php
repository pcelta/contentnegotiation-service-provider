<?php

namespace Dafiti\Silex\Response\Factory;

use Symfony\Component\HttpFoundation\Response;

interface Factorable
{
    /**
     * @param \Dafiti\Silex\Response $controllerResponse
     *
     * @return Response
     */
    public function create(\Dafiti\Silex\Response $controllerResponse);
}
