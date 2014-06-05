<?php

class SecureContainer {

    protected $target = null;
    protected $acl = null;

    public function __construct($target, $acl) {
        $this->target = $target;
        $this->acl = $acl;
    }

    public function __call($method, $arguments) {
        if (method_exists($this->target, $method)
                && $this->acl->isAllowed(get_class($this->target), $method)) {
            return call_user_func_array(
                    array( $this->target, $method ),
                    $arguments
                );
        } else {
            throw new Exception("Unauthorized");
        }
    }

}

?>