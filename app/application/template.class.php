<?php

/**
 *  This class provides base functionality for calling and creating
 *  views.
 *
 *  @since 1.0.0
 */
class Template {

    /**
     *  Registry containing application-scoped data.
     *
     *  @since 1.0.0
     *  @access private
     *  
     *  @var array $registry
     */
    private $registry;
    
    /*
     *  Container for view-scoped variables.
     *
     *  @since 1.0.0
     *  @access private
     *
     *  @var array $vars
     */
    private $vars = array();

    /**
     *  Default constructor.
     *
     *  @since 1.0.0
     */
    function __construct($registry) {
        $this->registry = $registry;
    }

    /**
     *  PHP magic setter to set view variables.
     *
     *  @since 1.0.0
     *  
     *  @param mixed $index The variables to make available to the view.
     *  @param mixed $value The value to use for the given $index.
     */
    public function __set($index, $value) {
        $this->vars[$index] = $value;
    }

    /**
     *  Displays a view.
     *
     *  @since 1.0.0
     *  
     *  @param string $name The view name.
     */
    public function show($name) {
        $path = __SITE_PATH . '/views' . '/' . $name . '.view.php';

        if (file_exists($path) == false) {
            throw new Exception('Template not found in '. $path);
            return false;
        }

        // Load variables
        foreach ($this->vars as $key => $value) {
            $$key = $value;
        }
        include ($path);
    }

}

?>