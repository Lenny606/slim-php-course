<?php

//loads namespaces , package
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use DI\Container;

//imports all depedencies
require __DIR__ . '/../../vendor/autoload.php';

//create Container
$container = new Container();

//registering new service for Mustache template engine
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
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = ucfirst($args['name']);  //ucfirst capitalize first letter 
    $response->getBody()->write('hello' . " " . $name);
    return $response;
});

//app is ready and can be runned
$app->run();
