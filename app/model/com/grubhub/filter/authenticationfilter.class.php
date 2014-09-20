<?php

class AuthenticationFilter implements Filter {

    public static function doFilter($controller, $registry) {
        // TODO
        $currentUser = $registry->session->getUser();
        if ($currentUser === null OR !is_object($currentUser) OR get_class($currentUser) !== "User") {
            throw new NotAuthenticatedException(MessageConfig::USER_NOT_AUTHENTICATED_MISSING_USER);
        }
        if ($currentUser->getUsername() === null) {
            throw new NotAuthenticatedException(MessageConfig::USER_NOT_AUTHENTICATED_MISSING_USERNAME);
        }
        if ($currentUser->getPassword() === null) {
            throw new NotAuthenticatedException(MessageConfig::USER_NOT_AUTHENTICATED_MISSING_PASSWORD);
        }
        return $controller;
    }

}

?>