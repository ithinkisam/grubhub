<?php

/**
 *  This bean class represents a comment (as in a statement or phrase
 *  made by something capable of reasoning and responding to
 *  something in a somewhat intelligent manner).
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
class Comment extends ObjectBase implements JsonSerializable, I_Comparable {
    
    /* Private instance data */
    private $_description_STR;
    private $_timestamp_INT;
    
    function __construct($description, $timestamp=false) {
        $this->setDescription($description);
        if ($timestamp !== false) {
            $this->setTimestamp($timestamp);
        } else {
            $this->setTimestamp(time());
        }
    }
    
    /* Getters 'n Setters */
    public function getDescription() {
        return $this->_description_STR;
    }
    
    public function setDescription($description) {
        parent::verifyType($description, "string");
        $this->_description_STR = $description;
    }
    
    public function getTimestamp() {
        return $this->_timestamp_INT;
    }
    
    public function setTimestamp($timestamp=false) {
        if ($timestamp !== false) {
            parent::verifyTypes($timestamp, array("integer", "double"));
            $this->_timestamp_INT = $timestamp;
        } else {
            $this->_timestamp_INT = time();
        }
    }
    
    public function __toString() {
        $fields = array();
        $fields[] = "description=" . $this->getDescription();
        $fields[] = "timestamp=" . $this->getTimestamp();
        
        return "Comment[" . implode("::", $fields) . "]";
    }
    
    public function equals($comment) {
        parent::verifyType($comment, "Comment");
        return ($this->getDescription() === $comment->getDescription()
            && $this->getTimestamp() == $comment->getTimestamp());
    }
    
    public static function compareTo($thisComment, $thatComment) {
        $objBase = new ObjectBase();
        $objBase->verifyType($thisComment, "Comment");
        $objBase->verifyType($thatComment, "Comment");
        return $thisComment->getTimestamp() - $thatComment->getTimestamp();
    }
    
    public function jsonSerialize() {
        $fields = array();
        $fields["description"] = $this->getDescription();
        $fields["timestamp"] = $this->getTimestamp();
        return $fields;
    }
    
}
