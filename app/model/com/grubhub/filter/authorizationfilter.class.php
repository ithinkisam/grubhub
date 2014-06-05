<?php

class AuthorizationFilter implements Filter {

    public static function doFilter($controller, $registry) {
        // TODO
        //$currentUser = $registry->session->getCurrentUser();
        //$acl = new AccessControlList($currentUser);
        //$controller = new SecureContainer($controller, $acl);
        return $controller;
    }
    
}

?>