<?php

/**
 *  This class defines the attributes that will be present in
 *  a search result entry.
 *
 *  Change History:
 *      02/27/2014 (SDB) - New class
 */
class SearchResult extends ObjectBase implements JsonSerializable {

    private $_title_STR;
    private $_description_STR;
    private $_imageUrl_STR;
    private $_viewUrl_STR;
    
    function __construct() {
        // TODO
    }
    
    public function getTitle() {
        return $this->_title_STR;
    }
    
    public function setTitle($title) {
        parent::verifyType($title, "string");
        $this->_title_STR = $title;
    }
    
    public function getDescription() {
        return $this->_description_STR;
    }
    
    public function setDescription($description) {
        parent::verifyType($description, "string");
        $this->_description_STR = $description;
    }
    
    public function getImageUrl() {
        return $this->_imageUrl_STR;
    }
    
    public function setImageUrl($imageUrl) {
        parent::verifyType($imageUrl, "string");
        $this->_imageUrl_STR = $imageUrl;
    }
    
    public function getViewUrl() {
        return $this->_viewUrl_STR;
    }
    
    public function setViewUrl($viewUrl) {
        parent::verifyType($viewUrl, "string");
        $this->_viewUrl_STR = $viewUrl;
    }
    
    public function __toString() {
        $fields = array();
        $fields[] = "title=" . $this->getTitle();
        $fields[] = "description=" . $this->getDescription();
        $fields[] = "imageUrl=" . $this->getImageUrl();
        $fields[] = "viewUrl=" . $this->viewUrl();
        
        return "SearchResult[" . implode("::", $fields) . "]";
    }
    
    public function jsonSerialize() {
        $fields = array();
        $fields[] = "title=" . $this->getTitle();
        $fields[] = "description=" . $this->getDescription();
        $fields[] = "imageUrl=" . $this->getImageUrl();
        $fields[] = "viewUrl=" . $this->viewUrl();
        
        return $fields;
    }

}

?>