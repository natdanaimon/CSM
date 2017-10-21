<?php

namespace Controller;



class HomeController extends Controller{
    
    
    public function index($request,$response){
        $response->getBody()->write("55555555");
        return $response;
    }
}

