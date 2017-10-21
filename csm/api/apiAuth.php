<?php

$app->map(['GET','POST'], '/auth/login/{test}', function (Request $request, Response $response) {
   
    $test = $request->getAttribute('test');
    
    $response->getBody()->write($test);
    return $response;
});

