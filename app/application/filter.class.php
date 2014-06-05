<?php

/**
 *  This class holds all application filters to apply to each
 *  controller.
 *
 *  @since 1.0.0
 */
class FilterManager {

    private static $filters = array(
            "AuthenticationFilter"
            ,"AuthorizationFilter"
        );

    /**
     *  Applies all provided filters to the controller.
     *
     *  @since 1.0.0
     *  @var Controller $controller
     */
    public static function addFilters($controller, $registry) {
    
        foreach (self::$filters as $filter) {
            $controller = $filter::doFilter($controller, $registry);
        }
        return $controller;
    
    }

}

?>