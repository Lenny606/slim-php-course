<?php

//new autoload was created in composer 
//use cmd composer dump-autoload for updating autoload
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

abstract class Controller
{
    //avaliable for child classes
    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }

    //empty array as default, method as render method
    protected function render(Response $response, $template, $data = [])
    {
        $html = $this->ci->get('templating')->render($template, $data);
        $response->getBody()->write($html);
        return $response;
    }
}
