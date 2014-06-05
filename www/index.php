<?php

/**
 *  This class serves as the main controller for the entire site.
 *  Any requests made to this site will be routed to this script
 *  via a simple .htaccess file.
 *
 *  This pages responsibilities include:
 *      (1) Setting up the "classpath" for the site
 *      (2) Setting up a registry containing "global" variables
 *      (3) Initializing the router
 *      (4) Passing control to the router
 *
 *  @since 1.0.0
 */

// error reporting on in dev and off in production
if (isset($_SERVER["SystemRoot"]) !== false && $_SERVER["SystemRoot"] == "C:\\Windows") {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// define the site path constant
$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path . '/../app');

// include the init.php file
include __SITE_PATH . '/includes/init.php';

// load the router
$registry = new Registry();
$registry->request = new Request();
$registry->session = new Session();
$registry->router = new Router($registry);

// set the controller path
$registry->router->setPath(__SITE_PATH . '/controller');

// load up the template
$registry->template = new Template($registry);

// load the controller
$registry->router->load();
    
?>