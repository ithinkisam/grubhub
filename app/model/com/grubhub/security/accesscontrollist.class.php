<?php

class AccessControlList {

    public function __construct($user) {
        
    }
    
    public function isAllowed($target, $action) {
        return true;
    }

}

?>