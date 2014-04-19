<?php

/**
 *  This bean class represents a single ingredient in a recipe.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
class Ingredient extends ObjectBase implements JsonSerializable, I_Comparable {

    /* Private default values */
    const DEFAULT_INT = 0;
    const DEFAULT_STR = "";
    
    /* Private instance data */
    private $_id_INT;
    private $_amount_RNG;
    private $_unit_CUN;
    private $_description_STR;
    
    function __construct($amount, $unit, $description) {
        $this->setId(-1);
        $this->setAmount($amount);
        $this->setUnit($unit);
        $this->setDescription($description);
    }
    
    /* Specialty Functions */
    public static function getAmountFromString($string) {
        // TC todo
    }
    
    public static function getUnitFromString($string) {
        // TC todo
    }
    
    public static function getDescriptioNFromString($string) {
        // TC todo
    }
    
    public function simplify() {
        switch ($this->_UNIT_CUN) {
        case CookingUnit::TSP:
            $amount = $this->getAmount();
            if ($amount->greaterThan(2)) {
                $this->setUnit(CookingUnit::TBSP);
                $this->setAmount($amount->divide(3));
            }
            break;
        case CookingUnit::TBSP:
            $amount = $this->getAmount();
            if ($amount->lessThan(1)) {
                $this->setUnit(CookingUnit::TSP);
                $this->setAmount($amount->multiply(3));
            }
            break;
        case CookingUnit::OZ:
            $amount = $this->getAmount();
            if ($amount->greaterThan(15)) {
                $this->setUnit(CookingUnit::LB);
                $this->setAmount($amount->divide(16));
            }
            break;
        case CookingUnit::LB:
            $amount = $this->getAmount();
            if ($amount->lessThan(1)) {
                $this->setUnit(CookingUnit::OZ);
                $this->setAmount($amount->multiply(16));
            }
            break;
        case CookingUnit::PINT:
            $amount = $this->getAmount();
            if ($amount->greaterThan(1)) {
                $this->setUnit(CookingUnit::QUART);
                $this->setAmount($amount->divide(2));
                $this->simplify(); // check conv. to gallons
            }
            if ($amount->lessThan(1)) {
                $this->setUnit(CookingUnit::CUP);
                $this->setAmount($amount->multiply(2));
            }
            break;
        case CookingUnit::QUART:
            $amount = $this->getAmount();
            if ($amount->greaterThan(3)) {
                $this->setUnit(CookingUnit::GALLON);
                $this->setAmount($amount->divide(4));
            }
            if ($amount->lessThan(1)) {
                $this->setUnit(CookingUnit::PINT);
                $this->setAmount($amount->multiply(2));
            }
            break;
        case CookingUnit::GALLON:
            $amount = $this->getAmount();
            if ($amount->lessThan(1)) {
                $this->setUnit(CookingUnit::QUART);
                $this->setAmount($amount->multiply(4));
                $this->simplify();
            }
            break;
        default:
            // Do nothing
            break;
        }
    }
    
    /* Getters 'n Setters */
    public function getId() {
        return $this->_id_INT;
    }
    
    public function setId($id) {
        parent::verifyType($id, "integer");
        $this->_id_INT = $id;
    }
    
    public function getAmount() {
        return $this->_amount_RNG;
    }
    
    public function getAmountFractional() {
        return $this->_amount_RNG->getFractional();
    }
    
    public function setAmount($amount) {
        parent::verifyType($amount, "Range");
        $this->_amount_RNG = $amount;
    }
    
    public function getUnit() {
        return $this->_unit_CUN;
    }
    
    public function getUnitString() {
        if ($this->getAmount()->equals(1)) {
            return CookingUnit::toString($this->_unit_CUN);
        } else {
            return CookingUnit::toStrings($this->_unit_CUN);
        }
    }
    
    public function setUnit($unit) {
        parent::verifyType($unit, "integer");
        parent::verifyRange($unit, CookingUnit::MIN, CookingUnit::MAX);
        $this->_unit_CUN = $unit;
    }
    
    public function getDescription() {
        return $this->_description_STR;
    }
    
    public function setDescription($description) {
        parent::verifyType($description, "string");
        $this->_description_STR = $description;
    }
    
    public function getFullString() {
        $amount = $this->getAmountFractional();
        $unit = $this->getUnitString();
        $description = $this->getDescription();
        if ($amount === 0) {
            return $description;
        } else {
            return $amount . " " . $unit . " " . $description;
        }
    }
    
    public function __toString() {
        $fields = array();
        $fields[] = "id=" . $this->getId();
        $fields[] = "amount=" . $this->getAmount();
        $fields[] = "unit=" . $this->getUnitString();
        $fields[] = "description=" . $this->getDescription();
        
        return "Ingredient[" . implode("::", $fields) . "]";
    }
    
    public function equals($ingredient) {
        parent::verifyType($ingredient, "Ingredient");
        return ($this->getId() === $ingredient->getId()
            && $this->getAmount() === $ingredient->getAmount()
            && $this->getUnit() === $ingredient->getUnit()
            && $this->getDescription() === $ingredient->getDescription());
    }
    
    public static function compareTo($thisIngredient, $thatIngredient) {
        $objBase = new ObjectBase();
        $objBase->verifyType($thisIngredient, "Ingredient");
        $objBase->verifyType($thatIngredient, "Ingredient");
        // TODO
        return 0;
    }
    
    public function jsonSerialize() {
        $fields = array();
        $fields["id"] = $this->getId();
        $fields["amount"] = $this->getAmount()->jsonSerialize();
        $fields["unit"] = $this->getUnitString();
        $fields["description"] = $this->getDescription();
        return $fields;
    }

}
