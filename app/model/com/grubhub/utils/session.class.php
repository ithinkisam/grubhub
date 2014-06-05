<?php

/**
 *
 *
 */
class Session {

    private $currentUser;

    function __construct() {
        session_start();
    
        if (isset($_SESSION['user']) === false) {
            $_SESSION['user'] = '';
            $_SESSION['pass'] = '';
        }
        
        $user = $_SESSION['user'];
        $pass = $_SESSION['pass'];
        
        $this->currentUser = new User($user, $pass, "");
    }
    
    public function getCurrentUser() {
        return $this->currentUser;
    }
    
    public function destroy() {
        // TODO
    }

}

?>