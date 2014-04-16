<?php

/**
 *  Initializes the application context.
 *
 *  @since 1.0.0
 */

// include the controller class
include __SITE_PATH . '/application/' . 'controller_base.class.php';

// include the registry class
include __SITE_PATH . '/application/' . 'registry.class.php';

// include the router class
include __SITE_PATH . '/application/' . 'router.class.php';

// include the template class
include __SITE_PATH . '/application/' . 'template.class.php';

// auto load model classes
function __autoload($class_name) {
    $filename = strtolower($class_name) . '.class.php';
    $file = __SITE_PATH . '/model/' . $filename;

    if (file_exists($file) == false) {
        return false;
    }
    include ($file);
}

// a new registry object
$registry = new Registry();
$registry->db = db::getInstance();

?>