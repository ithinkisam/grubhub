<?php

/**
 *  This class serves as a template for creating hub display widgets
 *  for display on a webpage.
 *
 *  Change History:
 *      02/04/2014 (SDB) - Initial creation
 */
class HubCardTemplate extends ObjectBase implements I_Template {

    private $_name_STR;
    private $_recipeCount_INT;

    function __construct() {
        $recipeCount = 0;
    }
    
    public function compile() {
        $name = $this->getName();
        $recipeCount = $this->getRecipeCount();
        
        $h = <<<EOF
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">$name <span class="badge">$recipeCount</span></h4>
                </div>
                <div class="panel-body">
                    <p class="lead">Description goes here...</p>
                </div>
            </div>
        </div>
EOF;
        return $h;
    }
    
    public function getName() {
        return $this->_name_STR;
    }
    
    public function setName($name) {
        parent::verifyType($name, "string");
        $this->_name_STR = $name;
    }
    
    public function getRecipeCount() {
        return $this->_recipeCount_INT;
    }
    
    public function setRecipeCount($recipeCount) {
        parent::verifyType($recipeCount, "integer");
        $this->_recipeCount_INT = $recipeCount;
    }
    
    public function __toString() {
        $fields = array();
        $fields["name"] = $this->getName();
        $fields["recipeCount"] = $this->getRecipeCount();
        return $fields;
    }
    
}
