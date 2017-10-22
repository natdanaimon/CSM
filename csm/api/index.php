<?php
require __DIR__.'/../../vendor/autoload.php';
$app = new \Slim\App;
$container = $app->getContainer();

//------------------include Api------------------//
require  __DIR__.'/apiAuth.php';
//------------------include Api------------------//


$app->run();
