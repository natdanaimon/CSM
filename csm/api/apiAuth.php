<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->map(['GET','POST'], '/auth/login/{test}', function (Request $request, Response $response) {
   
    $test = $request->getAttribute('test');
    
    $response->getBody()->write($test);
    return $response;
});

