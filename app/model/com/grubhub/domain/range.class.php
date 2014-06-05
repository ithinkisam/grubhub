<?php

/**
 *  This bean class represents a range of numbers. It can be used
 *  for anything that can span more than a single unit of
 *  measurement.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
class Range extends ObjectBase implements JsonSerializable, I_Comparable {
    
    /* Private default values */
    const DEFAULT_INT = -1;
    const DEFAULT_STR = "";
    const NOT_SET = -999;
    
    /* Private instance data */
    private $_min_DBL;
    private $_max_DBL;
    private $_delimiter_STR = '-';
    
    function __construct($min, $max=null) {
        $this->setMin($min);
        if ($max !== null) {
            $this->setMax($max);
        } else {
            $this->setMax(self::NOT_SET);
        }
    }
    
    /* Speciality Functions */
    public function isSingular() {
        return !$this->isSpan() && $this->getMin() == 1;
    }
    
    public function isSpan() {
        return $this->getMax() == self::NOT_SET;
    }
    
    public function add($n) {
        if (gettype($n) == "object") {
            if (get_class($n) == "Range") {
                return $this->addRange($n);
            } else {
                parent::verifyType($n, "Range");
            }
        } else {
            return $this->addN(floatval($n));
        }
    }
    
    public function addRange($range) {
        parent::verifyType($range, "Range");
        $newRange = new Range($this->getMin() + $range->getMin());
        if ($this->isSpan() && $range->isSpan()) {
            $newRange->setMax($this->getMax() + $range->getMax());
        } else if ($this->isSpan()) {
            $newRange->setMax($this->getMax() + $range->getMin());
        } else if ($range->isSpan()) {
            $newRange->setMax($this->getMin() + $range->getMax());
        }
        return $newRange;
    }
    
    public function addN($n) {
        $newRange = new Range($this->getMin() + $n);
        if ($this->isSpan()) {
            $newRange->setMax($this->getMax() + $n);
        }
        return $newRange;
    }
    
    public function subtract($n) {
        if (gettype($n) == "object") {
            if (get_class($n) == "Range") {
                return $this->subtractRange($n);
            } else {
                parent::verifyType($n, "Range");
            }
        } else {
            return $this->subtractN(floatval($n));
        }
    }
    
    public function subtractRange($range) {
        parent::verifyType($range, "Range");
        $newRange = new Range($this->getMin() - $range->getMin());
        if ($this->isSpan() && $range->isSpan()) {
            $newRange->setMax($this->getMax() - $range->getMax());
        } else if ($this->isSpan()) {
            $newRange->setMax($this->getMax() - $range->getMin());
        } else if ($range->isSpan()) {
            $newRange->setMax($this->getMin() - $range->getMax());
        }
        return $newRange;
    }
    
    public function subtractN($n) {
        $newRange = new Range($this->getMin() - $n);
        if ($this->isSpan()) {
            $newRange->setMax($this->getMax() - $n);
        }
        return $newRange;
    }
    
    public function divide($n) {
        if (gettype($n) == "object") {
            if (get_class($n) == "Range") {
                return $this->divideRange($n);
            } else {
                parent::verifyType($n, "Range");
            }
        } else {
            return $this->divideN(floatval($n));
        }
    }
    
    public function divideRange($range) {
        parent::verifyType($range, "Range");
        $newRange = new Range($this->getMin() / $range->getMin());
        if ($this->isSpan() && $range->isSpan()) {
            $newRange->setMax($this->getMax() / $range->getMax());
        } else if ($this->isSpan()) {
            $newRange->setMax($this->getMax() / $range->getMin());
        } else if ($range->isSpan()) {
            $newRange->setMax($this->getMin() / $range->getMax());
        }
        return $newRange;
    }
    
    public function divideN($n) {
        $newRange = new Range($this->getMin() / $n);
        if ($this->isSpan()) {
            $newRange->setMax($this->getMax() / $n);
        }
        return $newRange;
    }
    
    public function intDivide($n) {
        if (gettype($n) == "object") {
            if (get_class($n) == "Range") {
                return $this->intDivideRange($n);
            } else {
                parent::verifyType($n, "Range");
            }
        } else {
            return $this->intDivideN(floatval($n));
        }
    }
    
    public function intDivideRange($range) {
        parent::verifyType($range, "Range");
        $newRange = new Range(intval($this->getMin() / $range->getMin()));
        if ($this->isSpan() && $range->isSpan()) {
            $newRange->setMax(intval($this->getMax() / $range->getMax()));
        } else if ($this->isSpan()) {
            $newRange->setMax(intval($this->getMax() / $range->getMin()));
        } else if ($range->isSpan()) {
            $newRange->setMax(intval($this->getMin() / $range->getMax()));
        }
        return $newRange;
    }
    
    public function intDivideN($n) {
        $newRange = new Range(intval($this->getMin() / $n));
        if ($this->isSpan()) {
            $newRange->setMax(intval($this->getMax() / $n));
        }
        return $newRange;
    }
    
    public function multiply($n) {
        if (gettype($n) == "object") {
            if (get_class($n) == "Range") {
                return $this->multiplyRange($n);
            } else {
                parent::verifyType($n, "Range");
            }
        } else {
            return $this->multiplyN(floatval($n));
        }
    }
    
    public function multiplyRange($range) {
        parent::verifyType($range, "Range");
        $newRange = new Range($this->getMin() * $range->getMin());
        if ($this->isSpan() && $range->isSpan()) {
            $newRange->setMax($this->getMax() * $range->getMax());
        } else if ($this->isSpan()) {
            $newRange->setMax($this->getMax() * $range->getMin());
        } else if ($range->isSpan()) {
            $newRange->setMax($this->getMin() * $range->getMax());
        }
        return $newRange;
    }
    
    public function multiplyN($n) {
        $newRange = new Range($this->getMin() * $n);
        if ($this->isSpan()) {
            $newRange->setMax($this->getMax() * $n);
        }
        return $newRange;
    }
    
    public function mod($n) {
        if (gettype($n) == "object") {
            if (get_class($n) == "Range") {
                return $this->modRange($n);
            } else {
                parent::verifyType($n, "Range");
            }
        } else {
            return $this->modN(floatval($n));
        }
    }
    
    public function modRange($range) {
        parent::verifyType($range, "Range");
        $newRange = new Range($this->getMin() % $range->getMin());
        if ($this->isSpan() && $range->isSpan()) {
            $newRange->setMax($this->getMax() % $range->getMax());
        } else if ($this->isSpan()) {
            $newRange->setMax($this->getMax() % $range->getMin());
        } else if ($range->isSpan()) {
            $newRange->setMax($this->getMin() % $range->getMax());
        }
        return $newRange;
    }
    
    public function modN($n) {
        $newRange = new Range($this->getMin() % $n);
        if ($this->isSpan()) {
            $newRange->setMax($this->getMax() % $n);
        }
        return $newRange;
    }
    
    public function lessThan($n) {
        if (gettype($n) == "object") {
            if (get_class($n) == "Range") {
                return $this->lessThanRange($n);
            } else {
                parent::verifyType($n, "Range");
            }
        } else {
            return $this->lessThanN(floatval($n));
        }
    }
    
    public function lessThanRange($range) {
        parent::verifyType($range, "Range");
        if ($this->isSpan() && $range->isSpan()) {
            return $this->getMin() < $range->getMin()
                    && $this->getMax() < $range->getMax();
        } else if ($this->isSpan()) {
            return $this->getMax() < $range->getMin();
        } else {
            return $this->getMin() < $range->getMin();
        }
    }
    
    public function lessThanN($n) {
        if ($this->isSpan()) {
            return $this->getMax() < $n;
        } else {
            return $this->getMin() < $n;
        }
    }
    
    public function greaterThan($n) {
        if (gettype($n) == "object") {
            if (get_class($n) == "Range") {
                return $this->greaterThanRange($n);
            } else {
                parent::verifyType($n, "Range");
            }
        } else {
            return $this->greaterThanN(floatval($n));
        }
    }
    
    public function greaterThanRange($range) {
        parent::verifyType($range, "Range");
        if ($this->isSpan() && $range->isSpan()) {
            return $this->getMin() > $range->getMin()
                    && $this->getMax() > $range->getMax();
        } else if ($range->isSpan()) {
            return $this->getMin() > $range->getMax();
        } else {
            return $this->getMin() > $range->getMin();
        }
    }
    
    public function greaterThanN($n) {
        return $this->getMin() > $n;
    }
    
    public function equals($n) {
        if (gettype($n) == "object") {
            if (get_class($n) == "Range") {
                return $this->equalsRange($n);
            } else {
                parent::verifyType($n, "Range");
            }
        } else {
            return $this->equalsN(floatval($n));
        }
    }
    
    public function equalsRange($range) {
        parent::verifyType($range, "Range");
        return $this->getMin() === $range->getMin()
                && $this->getMax() === $range->getMax();
    }
    
    public function equalsN($n) {
        return !$this->isSpan() && $this->getMin() === $n;
    }
    
    public function getDecimal() {
        if (!$this->isSpan()) {
            if ($this->getMin() === intval($this->getMin())) {
                return $this->getMin();
            }
            return number_format($this->getMin(), 2);
        } else {
            if ($this->getMin === intval($this->getMin())) {
                $min = $this->getMin();
            } else {
                $min = number_format($this->getMin(), 2);
            }
            if ($this->getMax() === intval($this->getMax())) {
                $max = $this->getMax();
            } else {
                $max = number_format($this->getMax(), 2);
            }
            return $min . $this->getDelimiter() . $max;
        }
    }
    
    public function getIntegral() {
        if (!$this->isSpan()) {
            if ($this->getMin() === intval($this->getMin())) {
                return $this->getMin();
            }
            return intval($this->getMin());
        } else {
            if ($this->getMin === intval($this->getMin())) {
                $min = $this->getMin();
            } else {
                $min = intval($this->getMin());
            }
            if ($this->getMax() === intval($this->getMax())) {
                $max = $this->getMax();
            } else {
                $max = intval($this->getMax());
            }
            return $min . $this->getDelimiter() . $max;
        }
    }
    
    public function getFractional() {
        if (!$this->isSpan()) {
            return parent::decimalToFraction($this->getMin());
        } else {
            return parent::decimalToFraction($this->getMin())
                    . $this->getDelimiter()
                    . parent::decimalToFraction($this->getMax());
        }
    }
    
    /* Getters 'n Setters */
    public function getMin() {
        return $this->_min_DBL;
    }
    
    public function setMin($min) {
        $min = parent::fractionToDecimal($min);
        parent::verifyTypes($min, array("integer", "double"));
        if ($this->isSpan()) {
            parent::verifyRange($min, 0, $this->getMax());
        }
        $this->_min_DBL = $min;
    }
    
    public function getMax() {
        return $this->_max_DBL;
    }
    
    public function setMax($max) {
        $max = parent::fractionToDecimal($max);
        parent::verifyTypes($max, array("integer", "double"));
        if ($this->isSpan()) {
            parent::verifyRange($max, $this->getMin(), parent::INFINITY);
        }
        $this->_max_DBL = $max;
    }
    
    public function getDelimiter() {
        return $this->_delimiter_STR;
    }
    
    public function setDelimiter($delimiter) {
        $this->_delimiter_STR = $delimiter;
    }
    
    public static function compareTo($thisRange, $thatRange) {
        $objBase = new ObjectBase();
        $objBase->verifyType($thisRange, "Range");
        $objBase->verifyType($thatRange, "Range");
        if ($thisRange->lessThan($thatRange)) {
            return -1;
        } else if ($thisRange->greaterThan($thatRange)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function __toString() {
        $fields = array();
        $fields[] = "min=" . $this->getMin();
        $fields[] = "max=" . $this->getMax();
        $fields[] = "delimiter=" . $this->getDelimiter();
        
        return "Range[" . implode("::", $fields) . "]";
    }
    
    public function jsonSerialize() {
        $fields = array();
        $fields["min"] = $this->getMin();
        $fields["max"] = $this->getMax();
        $fields["delimiter"] = $this->getDelimiter();
        $fields["decimal"] = $this->getDecimal();
        $fields["integral"] = $this->getIntegral();
        $fields["fractional"] = $this->getFractional();
        return $fields;
    }
    
}
