<?php

class AccessControlList extends DatabaseUser {

    private $user;

    public function __construct($user) {
        parent::verifyType($user, "User");
        $this->user = $user;
    }
    
    public function isAllowed($target, $action) {
        parent::verifyType($target, "string");
        parent::verifyType($action, "string");
        
        $result = $this->doFunction("f_isAuthorized",
                array("'" . $this->user->getUsername() . "'",
                      "'" . $target . "'",
                      "'" . $action . "'"));

        return $result > 0;
    }

}

?>