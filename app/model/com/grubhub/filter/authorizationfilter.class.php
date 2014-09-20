<?php

class AuthorizationFilter implements Filter {

    public static function doFilter($controller, $registry) {
        $currentUser = $registry->session->getUser();
        $acl = new AccessControlList($currentUser);
        return new SecureContainer($controller, $acl);
    }
    
}

?>