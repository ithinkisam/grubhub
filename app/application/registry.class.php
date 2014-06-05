<?php

/**
 *  This class serves as a container for application-scoped variables
 *  that need to be accessed by various components. Controllers and
 *  routers have access to the applications registry.
 *
 *  Magic get and set methods allow the application to set any
 *  variable it requires.
 *
 *  @since 1.0.0
 */
class Registry {

    /**
     *  Container to hold registry values.
     *
     *  @since 1.0.0
     *  @access private
     *  @var array $vars
     */
    private $vars = array();

    /**
     *  PHP magic setter.
     *
     *  @param mixed $index The index.
     *  @param mixed $value The value.
     */
    public function __set($index, $value) {
        $this->vars[$index] = $value;
    }

    /**
     *  PHP magic getter.
     *
     *  @param mixed $index The index.
     */
    public function __get($index) {
        return $this->vars[$index];
    }

}

?>