<?php

/**
 *  This bean class represents a single direction (or step) one
 *  must (should) follow when making a recipe.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
class Direction extends ObjectBase implements JsonSerializable, I_Comparable {

    /* Private default values */
    const DEFAULT_INT = -1;
    const DEFAULT_STR = "";
    const STEP_DELIMITER = ".";
    
    /* Private instance data */
    private $_stepNumber_INT;
    private $_description_STR;
    
    function __construct($stepNumber, $description) {
        $this->setStepNumber($stepNumber);
        $this->setDescription($description);
    }
    
    /* Speciality Functions */
    public function incrementStepNumber() {
        $this->_stepNumber_INT++;
    }
    
    public function decrementStepNumber() {
        if ($this->_stepNumber_INT > 1) {
            $this->_stepNumber_INT--;
        } else {
            throw new Exception(get_class() .
                '::decrementStepNumber: Cannot decrement step number any further');
        }
    }
    
    /* Getters 'n Setters */
    public function getStepNumber() {
        return $this->_stepNumber_INT;
    }
    
    public function setStepNumber($stepNumber) {
        parent::verifyType($stepNumber, "integer");
        parent::verifyRange($stepNumber, 0, parent::INFINITY);
        $this->_stepNumber_INT = $stepNumber;
    }
    
    public function getDescription() {
        return $this->_description_STR;
    }
    
    public function setDescription($description) {
        parent::verifyType($description, "string");
        $this->_description_STR = $description;
    }
    
    public function __toString() {
        $fields = array();
        $fields[] = "stepNumber=" . $this->getStepNumber();
        $fields[] = "description=" . $this->getDescription();
        
        return "Direction[" + implode("::", $fields) . "]";
    }
    
    public function equals($direction) {
        parent::verifyType($direction, "Direction");
        return ($this->getStepNumber() === $direction->getStepNumber()
            && $this->getDescription() === $direction->getDescription());
    }
    
    public static function compareTo($thisDirection, $thatDirection) {
        $objBase = new ObjectBase();
        $objBase->verifyType($thisDirection, "Direction");
        $objBase->verifyType($thatDirection, "Direction");
        return $thisDirection->getStepNumber() - $thatDirection->getStepNumber();
    }
    
    public function jsonSerialize() {
        $fields = array();
        $fields["stepNumber"] = $this->getStepNumber();
        $fields["description"] = $this->getDescription();
        return $fields;
    }

}
