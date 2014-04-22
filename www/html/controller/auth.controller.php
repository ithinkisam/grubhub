<?php

/**
 *  Authentication controller.
 *
 *  @since 1.0.0
 */
class AuthController extends BaseController {

    /**
     *  See BaseController.index()
     */
    public function index() {
        echo "Auth Index";
    }
    
    /**
     *  
     */
    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = SecurityManager::encrypt($password);
        
        $_SESSION['user'] = $username;
        $_SESSION['pass'] = $password;
    
        $sec = new SecurityManager();
        try {
            $sec->authenticate($_SESSION);
        } catch (Exception $e) {
            unset($_SESSION['user']);
            unset($_SESSION['pass']);
        }
        $this->redirect("/");
    }
    
    /**
     *
     */
    public function logout() {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                        $params["path"], $params["domain"],
                        $params["secure"], $params["httponly"]
                        );
        }
        session_destroy();
        $this->redirect("/");
    }

}
