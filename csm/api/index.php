<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__.'/../../vendor/autoload.php';



$app = new \Slim\App;

$container = $app->getContainer();

$container['HomeController'] = function ($container){
    return new \Controller\HomeController($container);
};


$app->map(['GET'], '/test/{test}', function (Request $request, Response $response) {
    $db = new Common\ConnectDB;
    $test = $request->getAttribute('test');
    
    $response->getBody()->write($test);
    return $response;
});

//$app->map(['GET','POST'], '/auth/login/{test}', function (Request $request, Response $response) {
//   
//    $test = $request->getAttribute('test');
//    
//    $response->getBody()->write($test);
//    return $response;
//});

//$app->map(['GET','POST'], '/auth/login/{test}', function (Request $request, Response $response) {
//   
//    $test = $request->getAttribute('test');
//    
//    $response->getBody()->write($test." | ".__DIR__);
//    return $response;
//});

//include 'apiAuth.php';

$app->run();
