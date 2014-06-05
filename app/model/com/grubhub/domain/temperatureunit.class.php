<?php

/**
 *  This abstract class represents a unit associated with
 *  temperature.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
abstract class TemperatureUnit {

    const UNKNOWN    = -1;
    const NONE       = 0;
    const FAHRENHEIT = 1;
    const CELCIUS    = 2;
    
    const MIN = -1;
    const MAX = 2;
    
    /**
     *
     *
     *  @param unit 
     *  @return 
     */
    public static function toString($unit) {
        switch ($unit) {
        case self::NONE:
            return "";
        case self::FAHRENHEIT:
            return "&deg;F";
        case self::CELCIUS:
            return "&deg;C";
        case self::UNKNOWN:
        default:
            return "?";
        }
    }
    
    /**
     *  
     *
     *  @param unit
     *  @return 
     */
    public static function toStrings($unit) {
        return self::toString($unit);
    }
    
    /**
     *  
     *
     *  @param string
     *  @return 
     */
    public static function toValue($string) {
        $string = strtolower($string);
        switch ($string) {
        case "":
        case "none":
            return self::NONE;
        case "f":
        case "&deg;f":
        case "&deg; f":
        case "degree f":
        case "degrees f":
        case "fahrenheit":
        case "degrees fahrenheit":
            return self::FAHRENHEIT;
        case "c":
        case "&deg;c":
        case "&deg; c":
        case "degree c":
        case "degrees c":
        case "celcius":
        case "degrees celcius":
            return self::CELCIUS;
        case "?":
        case "UNKNOWN":
        default:
            return self::UNKNOWN;
        }
    }

}
