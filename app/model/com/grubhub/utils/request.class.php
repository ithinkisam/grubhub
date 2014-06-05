<?php

class Request {

    private $method;
    private $controller;
    private $action;
    private $parameters;
    
    function __construct() {
        $method = $_SERVER['REQUEST_METHOD'];
    
        $route = (empty($_GET['rt'])) ? '' : $_GET['rt'];
        
        if (empty($route)) {
            $route = 'index';
        } else {
            $parts = explode('/', $route);
            $this->controller = $parts[0];
            if (isset($parts[1])) {
                $this->action = $parts[1];
            }
        }
        
        if (empty($this->controller)) {
            $this->controller = 'index';
        }
        if (empty($this->action)) {
            $this->action = 'index';
        }
        
        if ($this->method == "POST") {
            $this->parameters = $_POST;
        } else {
            $this->parameters = $_GET;
        }
    }
    
    public function getController() {
        return $this->controller;
    }
    
    public function getAction() {
        return $this->action;
    }
    
    public function getParam($key) {
        if (array_key_exists($key, $this->parameters)) {
            return $this->parameters[$key];
        } else {
            return '';
        }
    }

}

?>
