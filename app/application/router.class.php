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
     */
    public $file;
    
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
     *  Invokes the appropriate controller action.
     *
     *  @since 1.0.0
     */
    public function load() {
        // check the route
        $controller = $this->registry->request->getController();
        $this->file = $this->path . '/' . $controller . '.controller.php';
        
        // if the file is not there, server a 404
        if (is_readable($this->file) === false) {
            $this->file = $this->path . '/error404.controller.php';
            $controller = 'error404';
        }
        
        // include the controller
        include $this->file;
        
        // a new controller class instance
        $class = $controller . 'Controller';
        $controller = new $class($this->registry);
        
        // check if the action is callable
        $action = $this->registry->request->getAction();
        if (is_callable(array($controller, $action)) === false) {
            $action = 'index';
        } else {
            $action = $action;
        }
        
        // Add filters
        $controller = FilterManager::addFilters($controller, $this->registry);
        
        // run the action
        try {
            $controller->$action();
        } catch (NotAuthenticatedException $e) {
            // TODO
            // route to "unauthenticated" controller
        } catch (NotAuthorizedException $e) {
            // TODO
            // route to "unauthorized" controller
        } catch (Exception $e) {
            // TODO
            // catch-all
        }
    }

}

?>