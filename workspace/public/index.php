<?php

//loads namespaces , package
// namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use DI\Container; //for dependency injection

//imports all depedencies
require __DIR__ . '/../vendor/autoload.php';

//create Container for services
$container = new Container();

//registering new service for Mustache template engine into container
$container->set('templating', function () {
    return new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(
            __DIR__ . '/../templates/',
            ['extension' => '']
        )
    ]);
});

AppFactory::setContainer($container);

//creates app 
$app = AppFactory::create();

//defines route
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('Welcome');
    return $response;
});

//second route
$app->get('/hello', function (Request $request, Response $response) {
    $response->getBody()->write('hello');
    return $response;
});

// route with parameters, third argument needed in function 
$app->get('/hello/test/{name}', function (Request $request, Response $response, array $args) {
    $name = ucfirst($args['name']);  //ucfirst capitalize first letter 
    $response->getBody()->write('hello, ' . $name);
    return $response;
});

// route with parameters, templating service 
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = ucfirst($args['name']);
    $html = $this->get('templating')->render('hello.html', [
        'name' => $name
    ]);
    $response->getBody()->write($html);
    return $response;
});

//wiring the custom Controllers
//instead of function class name and method name is passed
//Slim syntax => Controller:method
$app->get('/homepage', '\App\Controller\FirstController:homepage');
$app->get('/hello2', '\App\Controller\SecondController:hello');
$app->get('/albums', '\App\Controller\SearchController:albums');
$app->get('/search', '\App\Controller\SearchController:search');
//used method any() => get/post method is choosed 
$app->any('/form', '\App\Controller\SearchController:form');
$app->get('/api', '\App\Controller\ApiController:search');

//app is ready and can be runned
$app->run();
