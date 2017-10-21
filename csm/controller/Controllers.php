<?php

namespace Controller;

class Controller {
    
    protected $container;
    protected  $view;
    
    public function __construct($container) {
        $this->container = $container;
        $this->view = $container->view;
    }
    
    public function __get($property) {
        
        if($this->container->{$property}){
            return $this->container->{$property};
        }
   
    }
}
