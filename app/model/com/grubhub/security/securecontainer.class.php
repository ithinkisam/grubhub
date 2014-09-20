<?php

class SecureContainer {

    protected $_target_OBJ = null;
    protected $_acl = null;

    public function __construct($target, $acl) {
        $this->_target_OBJ = $target;
        $this->_acl = $acl;
    }

    public function __call($method, $arguments) {
        if (method_exists($this->_target_OBJ, $method)
                && $this->_acl->isAllowed(get_class($this->_target_OBJ), $method)) {
            return call_user_func_array(
                    array($this->_target_OBJ, $method),
                    $arguments
                );
        } else {
            throw new NotAuthorizedException(MessageConfig::USER_NOT_AUTHORIZED);
        }
    }

}

?>