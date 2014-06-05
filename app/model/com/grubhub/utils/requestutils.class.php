<?php

class RequestUtils extends ObjectBase {

    /**
     *  Determines whether the supplied parameter was given a
     *  value when it was passed in.
     *
     *  @param {string} param The parameter to check.
     *  @return {boolean} true if the parameter has a value other
     *          than null or the empty string, false otherwise.
     */
    public static function isParameterSpecified($param) {
        return $param !== null && $param !== "";
    }
    
    /**
     *  Determines whether the supplied parameter contains a
     *  valid value.
     *
     *  @param {string} param The parameter to check.
     *  @param {array:string} values The values that param is
     *          allowed to contain.
     *  @return {boolean} true if the parameter contains a valid
     *          value, false otherwise.
     */
    public static function isParameterValid($param, $values) {
        if (!is_array($values)) {
            return false;
        }
        
        foreach ($values as $value) {
            if ($param === $value) {
                return true;
            }
        }
        return false;
    }

}
