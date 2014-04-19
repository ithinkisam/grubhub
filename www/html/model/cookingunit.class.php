<?php

/**
 *  This abstract class represents a unit associated with cooking.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
abstract class CookingUnit {

    const UNKNOWN   = -1;
    const NONE      = 0;
    const TSP       = 1;
    const TBSP      = 2;
    const OZ        = 3;
    const LB        = 4;
    const CUP       = 5;
    const PINT      = 6;
    const QUART     = 7;
    const GALLON    = 8;
    const CAN       = 9;
    const PINCH     = 10;
    const LITER     = 11;
    const SMALL     = 12;
    const MEDIUM    = 13;
    const LARGE     = 14;
    const RIB       = 15;
    const CLOVE     = 16;
    const PACKAGE   = 17;
    const STALK     = 18;
    const JAR       = 19;
    const BOTTLE    = 20;
    const RECIPE    = 21;
    const LOAF      = 22;
    const CONTAINER = 23;
    const ENVELOPE  = 24;
    const BAG       = 25;
    
    const MIN       = -1;
    const MAX       = 25;
    
    public static function toString($unit) {
        switch ($unit) {
        case self::NONE:
            return "";
        case self::TSP:
            return "tsp";
        case self::TBSP:
            return "tbsp";
        case self::OZ:
            return "oz";
        case self::LB:
            return "lb";
        case self::CUP:
            return "cup";
        case self::PINT:
            return "pint";
        case self::QUART:
            return "quart";
        case self::GALLON:
            return "gallon";
        case self::CAN:
            return "can";
        case self::PINCH:
            return "pinch";
        case self::LITER:
            return "liter";
        case self::SMALL:
            return "small";
        case self::MEDIUM:
            return "medium";
        case self::LARGE:
            return "large";
        case self::RIB:
            return "rib";
        case self::CLOVE:
            return "clove";
        case self::PACKAGE:
            return "package";
        case self::STALK:
            return "stalk";
        case self::JAR:
            return "jar";
        case self::BOTTLE:
            return "bottle";
        case self::RECIPE:
            return "recipe";
        case self::LOAF:
            return "loaf";
        case self::CONTAINER:
            return "container";
        case self::ENVELOPE:
            return "envelope";
        case self::BAG:
            return "bag";
        default:
            return "?";
        }
    }
    
    public static function toStrings($unit) {
        switch ($unit) {
        case self::NONE:
            return "";
        case self::TSP:
            return "tsps";
        case self::TBSP:
            return "tbsps";
        case self::OZ:
            return "oz";
        case self::LB:
            return "lbs";
        case self::CUP:
            return "cups";
        case self::PINT:
            return "pints";
        case self::QUART:
            return "quarts";
        case self::GALLON:
            return "gallons";
        case self::CAN:
            return "cans";
        case self::PINCH:
            return "pinchs";
        case self::LITER:
            return "liters";
        case self::SMALL:
            return "small";
        case self::MEDIUM:
            return "medium";
        case self::LARGE:
            return "large";
        case self::RIB:
            return "ribs";
        case self::CLOVE:
            return "cloves";
        case self::PACKAGE:
            return "packages";
        case self::STALK:
            return "stalks";
        case self::JAR:
            return "jars";
        case self::BOTTLE:
            return "bottles";
        case self::RECIPE:
            return "recipes";
        case self::LOAF:
            return "loaves";
        case self::CONTAINER:
            return "containers";
        case self::ENVELOPE:
            return "envelopes";
        case self::BAG:
            return "bags";
        default:
            return "?s";
        }
    }
    
    public static function toValue($string) {
        if (strlen($string) != 1) {
            $string = strtolower($string);
        }
    
        switch ($string) {
        case "":
        case "none":
            return self::NONE;
        case "t":
        case "tsp":
        case "tsps":
        case "teaspoon":
        case "teaspoons":
            return self::TSP;
        case "T":
        case "tbsp":
        case "tbsps":
        case "tablespoon":
        case "tablespoons":
            return self::TBSP;
        case "oz":
        case "oz.":
        case "ounce":
        case "ounces":
            return self::OZ;
        case "lb":
        case "lb.":
        case "lbs":
        case "pound":
        case "pounds":
            return self::LB;
        case "cp":
        case "cps":
        case "cup":
        case "cups":
            return self::CUP;
        case "pint":
        case "pints":
            return self::PINT;
        case "qt":
        case "qts":
        case "quart":
        case "quarts":
            return self::QUART;
        case "gal":
        case "gals":
        case "gallon":
        case "gallons":
            return self::GALLON;
        case "can":
        case "cans":
            return self::CAN;
        case "pinch":
        case "pinchs":
            return self::PINCH;
        case "l":
        case "L":
        case "liter":
        case "liters":
            return self::LITER;
        case "sm":
        case "small":
            return self::SMALL;
        case "med":
        case "medium":
            return self::MEDIUM;
        case "lg":
        case "large":
            return self::LARGE;
        case "rib":
        case "ribs":
            return self::RIB;
        case "clove":
        case "cloves":
            return self::CLOVE;
        case "package":
        case "packages":
            return self::PACKAGE;
        case "stalk":
        case "stalks":
            return self::STALK;
        case "jar":
        case "jars":
            return self::JAR;
        case "bottle":
        case "bottles":
            return self::BOTTLE;
        case "recipe":
        case "recipes":
            return self::RECIPE;
        case "loaf":
        case "loafs":
        case "loaves":
            return self::LOAF;
        case "container":
        case "containers":
            return self::CONTAINER;
        case "env":
        case "envs";
        case "envelope";
        case "envelopes";
            return self::ENVELOPE;
        case "bag":
        case "bags":
            return self::BAG;
        case "?":
        case "unknown":
        default:
            return self::UNKNOWN;
        }
    }

}
