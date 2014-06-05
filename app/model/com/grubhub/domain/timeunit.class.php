<?php

/**
 *  This abstract class represents a unit associated with time.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
abstract class TimeUnit {

    const UNKNOWN = -1;
    const NONE    = 0;
    const SECOND  = 1;
    const MINUTE  = 2;
    const HOUR    = 3;
    const DAY     = 4;
    
    const MIN = -1;
    const MAX = 4;
    
    /**
     *  Simple toString for Enum returning singular string value
     *
     *  @param unit
     *  @return 
     */
    public static function toString($unit) {
        switch ($unit) {
        case self::NONE:
            return "";
        case self::SECOND:
            return "second";
        case self::MINUTE:
            return "minute";
        case self::HOUR:
            return "hour";
        case self::DAY:
            return "day";
        case UNKNOWN:
        default:
            return "?";
        }
    }
    
    /**
     *  Simple toString for Enum returning plural string value
     *
     *  @param unit
     *  @return 
     */
    public static function toStrings($unit) {
        switch ($unit) {
        case self::NONE:
            return "";
        case self::SECOND:
            return "seconds";
        case self::MINUTE:
            return "minutes";
        case self::HOUR:
            return "hours";
        case self::DAY:
            return "days";
        case UNKNOWN:
        default:
            return "?s";
        }
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
        case "s":
        case "s.":
        case "sec":
        case "sec.":
        case "second":
        case "seconds":
            return self::SECOND;
        case "m":
        case "m.":
        case "min":
        case "min.":
        case "minute":
        case "minutes":
            return self::MINUTE;
        case "h":
        case "hour":
        case "hours":
            return self::HOUR;
        case "d":
        case "day":
        case "days":
            return self::DAY;
        case "?":
        case "unknown":
        default:
            return self::UNKNOWN;
        }
    }

}
