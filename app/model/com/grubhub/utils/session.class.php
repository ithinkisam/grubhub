<?php

/**
 *
 *
 */
class Session {

    private $_user_USR;

    function __construct() {
        session_start();
    
        if (isset($_SESSION[AppConstants::SESSION_USER]) === false) {
            $_SESSION[AppConstants::SESSION_USER] = '';
            $_SESSION[AppConstants::SESSION_PASSWORD] = '';
        }
        
        $user = $_SESSION[AppConstants::SESSION_USER];
        $pass = $_SESSION[AppConstants::SESSION_PASSWORD];
        
        $this->_user_USR = new User($user, $pass);
    }
    
    public function getUser() {
        return $this->_user_USR;
    }
    
    public function destroy() {
        // TODO
    }

}

?>