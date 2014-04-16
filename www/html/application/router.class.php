<?php

/**
 *  This class is responsible for taking requests made to the main
 *  controller and delegating responsibilities to the appropriate
 *  custom controller.
 *  
 *  @since 1.0.0
 */
class Router {

    /**
     *  Registry to be passed to controllers.
     *
     *  @since 1.0.0
     *  @access private
     *
     *  @var array $registry
     */
    private $registry;
    
    /**
     *  Controller path.
     *
     *  @since 1.0.0
     *  @access private
     *
     *  @var string $path Location of the controller components.
     */
    private $path;
    
    /**
     *  Public class-level variables for controller delegation.
     *
     *  @since 1.0.0
     *  @access public
     *
     *  @var string $file The controller file.
     *  @var string $controller The controller class name.
     *  @var string $action The controller method to call.
     */
    public $file;
    public $controller;
    public $action;
    
    /**
     *  Default constructor.
     *
     *  @since 1.0.0
     */
    function __construct($registry) {
        $this->registry = $registry;
    }
    
    /**
     *  Sets the path to the controller files.
     *
     *  @since 1.0.0
     *
     *  @param string $path The file path.
     */
    public function setPath($path) {
        /*** check if path is a directory ***/
        if (is_dir($path) === false) {
            throw new Exception('Invalid controller path: `' . $path . '`');
        }
        /*** set the path ***/
        $this->path = $path;
    }
    
    /**
     *  Invokes the appropriate controller action based on the
     *  request provided.
     *
     *  @since 1.0.0
     */
    public function load() {
        // check the route
        $this->getController();
        
        // if the file is not there, die
        if (is_readable($this->file) === false) {
            $this->file = $this->path . '/error404.controller.php';
            $this->controller = 'error404';
        }
        
        // include the controller
        include $this->file;
        
        // a new controller class instance
        $class = $this->controller . 'Controller';
        $controller = new $class($this->registry);
        
        // check if the action is callable
        if (is_callable(array($controller, $this->action)) === false) {
            $action = 'index';
        } else {
            $action = $this->action;
        }
        
        // run the action
        $controller->$action();
    }
    
    /**
     *  Retrieves the appropriate controller components based on the
     *  request values.
     *
     *  @since 1.0.0
     *  @access private
     */
    private function getController() {
        // get the route from the url
        $route = (empty($_GET['rt'])) ? '' : $_GET['rt'];
        
        if (empty($route)) {
            $route = 'index';
        } else {
            // get the parts of the route
            $parts = explode('/', $route);
            $this->controller = $parts[0];
            if (isset($parts[1])) {
                $this->action = $parts[1];
            }
        }
        
        // get controller
        if (empty($this->controller)) {
            $this->controller = 'index';
        }
        
        // get action
        if (empty($this->action)) {
            $this->action = 'index';
        }
        
        // set the file path
        $this->file = $this->path . '/' . $this->controller . '.controller.php';
    }

}

?>