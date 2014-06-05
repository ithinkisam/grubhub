<?php

/**
 *  This bean class represents a unit of time, complete with value
 *  and type.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
class Time extends ObjectBase implements JsonSerializable, I_Comparable {
    
    private $_range_RNG;
    private $_unit_TMU;
    
    function __construct($range, $unit) {
        $this->setRange($range);
        $this->setUnit($unit);
    }
    
    /* Specialty Functions */
    
    
    /* Getters 'n Setters */
    
    /**
     *  @return 
     */
    public function getRange() {
        return $this->_range_RNG;
    }
    
    /**
     *  @param range 
     */
    public function setRange($range) {
        parent::verifyType($range, "Range");
        $this->_range_RNG = $range;
    }
    
    /**
     *  @return 
     */
    public function getUnit() {
        return $this->_unit_TMU;
    }
    
    public function getUnitString() {
        if ($this->getRange()->equals(1)) {
            return TimeUnit::toString($this->_unit_TMU);
        } else {
            return TimeUnit::toStrings($this->_unit_TMU);
        }
    }
    
    /**
     *  @param unit 
     */
    public function setUnit($unit) {
        parent::verifyType($unit, "integer");
        $this->_unit_TMU = $unit;
    }
    
    /**
     *   
     */
    public function __toString() {
        $fields = array();
        $fields[] = "range=" . $this->getRange();
        $fields[] = "unit=" . $this->getUnit();
        
        return "Time[" . implode("::", $fields) . "]";
    }
    
    /**
     *  
     */
    public function equals($time) {
        parent::verifyType($ingredient, "Time");
        return ($this->getRange()->equals($time->getRange())
            && $this->getUnit() === $time->getUnit());
    }
    
    public static function compareTo($thisTime, $thatTime) {
        $objBase = new ObjectBase();
        $objBase->verifyType($thisTime, "Time");
        $objBase->verifyType($thatTime, "Time");
        // TODO
        return 0;
    }
    
    public function jsonSerialize() {
        $fields = array();
        $fields["range"] = $this->getRange()->jsonSerialize();
        $fields["unit"] = $this->getUnitString();
        return $fields;
    }
    
}
