<?php

/**
 *  This class houses functions that are shared amonst all objects.
 *  Any common code that needs to be shared should be placed here.
 *
 *  Change History:
 *      01/10/2014 (SDB) Implemented docs
 */
class ObjectBase {

    const INFINITY = 9999999;
    
    /**
     *  Generates a random string composed of alphanumeric characters.
     *
     *  @param length
     *  @return 
     */
    public function randomString($length=15) {
        $chars1 = "abcdefghijkmnopqrstuvwxyz23456789ABCDEFGHJKMNPQRSTUVWXYZ";
		$chars2 = "UcQovwTG9C2J4XZnmFki7eYS5afsphHExRjdqN6gzWtr8KyuBV3MbPDA";
		$chars3 = "c6QwDefv7FpEH9qxuzJTCatdRPnoMXs3W2KUhgZbmiyYrk8GSBNV4Aj5";
		$chars4 = "KVG48BXnREkjgTC73rxZuPYasptHvADWfw62zimM5SQ9hcJeNoFdUqyb";
		$chars = array($chars1, $chars2, $chars3, $chars4);
		srand((double)microtime()*1000000);
		$str = "";
		while (strlen($str) < $length) {
			$num = rand() % 56;
			$index = rand() % 4;
			$tmp = substr($chars[$index], $num, 1);
			$str .= $tmp;
		}
		return $str;
    }

    /**
     *  Verifies the type of an object/primitive, throwing an exception
     *  if the type does not match the type provided.
     *
     *  @param obj
     *  @param type
     *  @param inner_type
     *  @throws Exception
     */
    public function verifyType($obj, $type, $inner_type=null) {
        if (is_object($obj)) {
            if (get_class($obj) !== $type) {
                throw new Exception(get_class() .
                        ':: Non-' . $type . ' value for ' .
                        get_class($obj) . ' object');
            }
        } else {
            if (gettype($obj) !== $type) {
                throw new Exception(get_class() .
                        ':: Non-' . $type . ' value for ' .
                        gettype($obj) . ' primitive');
            } else {
                if ($type === "array" && count($obj) > 0) {
                    foreach ($obj as $subObj) {
                        $this->verifyType($subObj, $inner_type);
                    }
                }
            }
        }
    }
    
    public function verifyTypes($obj, $types) {
        if (is_object($obj)) {
            foreach ($types as $type) {
                if (get_class($obj) == $type) {
                    return;
                }
            }
            throw new Exception(get_class() .
                    ':: ' . get_class($obj) . ' object is not ' .
                    'a valid type');
        } else {
            foreach ($types as $type) {
                if (gettype($obj) == $type) {
                    return;
                }
            }
            throw new Exception(get_class() .
                    ':: ' . get_class($obj) . ' primitive is not ' .
                    'a valid type');
        }
    }
    
    /**
     *  Verifies the length of a string, throwing an exception if
     *  the length of the string does not match the expected length.
     *
     *  @param string
     *  @param length
     *  @throws Exception
     */
    public function verifyStringLength($string, $length) {
        if (gettype($string) !== "string") {
            throw new Exception(get_class() .
                    ':: Non-string value');
        }
        if (strlen($string) !== $length) {
            throw new Exception(get_class() .
                    ':: String length mismatch');
        }
    }
    
    /**
     *  Verifies the length of a given value using strict comparison.
     *
     *  @param obj
     *  @param min
     *  @param max
     *  @throws Exception
     */
    public function verifyRange($value, $min, $max) {
        if ($value < $min || $value > $max) {
            throw new Exception(get_class() .
                    ':: Invalid range for ' . gettype($value));
        }
    }
    
    public function selectSubset($bucket, $n) {
        if (!is_array($bucket)) {
            throw new Exception(get_class() .
                    ':: selectSubset must take an array type');
        }
        if (count($bucket) <= $n) {
            return $bucket;
        }
        while (count($bucket) > $n) {
            $key = rand(0, count($bucket) - 1);
            unset($bucket[$key]);
            $bucket = array_values($bucket);
        }
        return $bucket;
    }
    
    /**
     *  
     *
     *  @param fraction
     *  @return
     */
    public function fractionToDecimal($fraction) {
        if ($fraction == "0" || (strpos($fraction, "/") === false && floatval($fraction) > 0)) {
			return floatval($fraction);
		}
		if (strpos($fraction, "/") !== false) {
			$pieces = explode(" ", $fraction);
		    if (count($pieces) == 2) {
				$whole = intval($pieces[0]);
				$fraction = explode("/", $pieces[1]);
			} else {
			    $whole = 0;
				$fraction = explode("/", $pieces[0]);
			}
			$numerator = intval($fraction[0]);
			$denominator = intval($fraction[1]);
			if ($denominator == 0) {
				return $whole;
			}
			return ($whole * $denominator + $numerator) / $denominator;
		}
		return 0;
    }
    
    /**
     *  
     *
     *  @param float
     *  @return 
     */
    public function decimalToFraction($float) {
        $whole = floor($float);
		$decimal = $float - $whole;
		$leastCommonDenom = 48;
		$denominators = array(2, 3, 4, 5, 6, 8, 9, 10, 12, 15, 16, 20, 24, 30, 32, 60, 64);
		$roundedDecimal = round( $decimal * $leastCommonDenom) / $leastCommonDenom;
		if ($roundedDecimal == 0) {
			return $whole;
		}
		if ($roundedDecimal == 1) {
			return $whole + 1;
		}
		foreach ($denominators as $d) {
			if ($roundedDecimal * $d == floor($roundedDecimal * $d)) {
				$denom = $d;
				break;
			}
		}
		return ($whole == 0 ? '' : $whole . ' ') . ($roundedDecimal * $denom) . "/" . $denom;
    }
    
    public function condenseString($string, $length) {
        if (strlen($string) <= $length) {
            return $string;
        } else {
            return substr($string, 0, $length);
        }
    }
    
}
