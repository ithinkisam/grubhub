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
     *  @var string $unauthenticatedController Controller file for
     *       unauthenticated users.
     *  @var string $unauthorizedController Controller file for
     *       unauthenticated users.
     */
    public $file;
    public $unauthenticatedController;
    public $unauthorizedController;
    
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
     *  Sets the controller for unauthenticated users.
     *
     *  @since 1.0.0
     *
     *  @param string $controller The controller to use.
     */
    public function setUnauthenticatedController($controller) {
        $this->unauthenticatedController = $controller;
    }
    
    /**
     *  Sets the controller for unauthorized users.
     *
     *  @since 1.0.0
     *
     *  @param string $controller The controller to use.
     */
    public function setUnauthorizedController($controller) {
        $this->unauthorizedController = $controller;
    }
    
    /**
     *  Invokes the appropriate controller action.
     *
     *  @since 1.0.0
     */
    public function load() {
    
        $controller = $this->getController($this->registry->request->getController());
        
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
            $controller = $this->getController(AppConstants::CONTROLLER_UNAUTHENTICATED);
            $controller->index();
        } catch (NotAuthorizedException $e) {
            $controller = $this->getController(AppConstants::CONTROLLER_UNAUTHORIZED);
            $controller->index();
        } catch (Exception $e) {
            $controller = $this->getController(AppConstants::CONTROLLER_ERROR);
            print "Exception: " . $e->getMessage . "<br/>";
            $controller->index();
        }
    }
    
    private function getController($controller) {
        $this->file = $this->path . '/' . $controller . '.controller.php';
        
        // If the file is not there, serve a 404
        if (is_readable($this->file) === false) {
            print "Could not find controller: " . $this->file . "<br/>";
            $controller = AppConstants::CONTROLLER_404;
            $this->file = $this->path . '/' . $controller . '.controller.php';
        }
        
        // Include the controller file
        include $this->file;
        
        // Instantiate a new controller class
        $class = $controller . 'Controller';
        return new $class($this->registry);
    }

}

?>