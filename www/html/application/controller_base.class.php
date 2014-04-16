<?php

/**
 *  This abstract class defines the methods necessary to be a
 *  controller class. Each controller will have access to a registry
 *  containing any application-scope variables to which it needs
 *  access. Every controller must also provide an index method as a
 *  default execution path.
 */
abstract class BaseController {

    /**
     *  @the registry
     */
    protected $registry;
    
    /**
     *  Default constructor
     */
    function __construct($registry) {
        $this->registry = $registry;
    }
    
    /**
     *  Default action if one if not provided in the request
     */
    abstract function index();

}

?>