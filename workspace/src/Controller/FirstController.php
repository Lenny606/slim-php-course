<?php

//new autoload was created in composer 
//use cmd composer dump-autoload for updating autoload
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

class FirstController
{
    //save container into variable
    private $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }

    public function homepage(Request $request, Response $response, array $args)
    {
        $html = $this->ci->get('templating')->render('homepage.html');
        $response->getBody()->write($html);
        return $response;
    }
}
