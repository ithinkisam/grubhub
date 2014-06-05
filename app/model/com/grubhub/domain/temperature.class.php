<?php

/**
 *  This bean class represents temperature, complete with value
 *  and unit.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
class Temperature extends ObjectBase implements JsonSerializable, I_Comparable {
    
    private $_range_RNG;
    private $_unit_TPU;
    
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
        return $this->_unit_TUN;
    }
    
    /**
     *  @return
     */
    public function getUnitString() {
        return TemperatureUnit::toString($this->_unit_TUN);
    }
    
    /**
     *  @param unit 
     */
    public function setUnit($unit) {
        parent::verifyType($unit, "integer");
        $this->_unit_TUN = $unit;
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
    
    public static function compareTo($thisTemp, $thatTemp) {
        $objBase = new ObjectBase();
        $objBase->verifyType($thisTemp, "Temperature");
        $objBase->verifyType($thisTemp, "Temperature");
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
