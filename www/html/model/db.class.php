<?php

class DB {

    private static $instance = null;
    
    private function __construct() {}
    
    public static function getInstance() {
        if (!self::$instance) {
            // setup db object
        }
        return self::$instance;
    }

    private function __clone() {}
    
}

?>