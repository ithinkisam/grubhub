<?php

class SimplyRecipesRecipeImporter extends RecipeImporter {

    private $_url_STR;
    private $_siteName_STR;
    private $_siteLogoUrl_STR;
    
    function __construct() {
        $this->_siteName_STR = "Simply Recipes";
        
        $page = new Page();
        $this->_siteLogoUrl_STR = $page->getImage("recipe-importers/simply-recipes.png");
    }

    public function getRecipe() {
        $recipe = new Recipe("New Recipe - Simply Recipes");
        $recipe->setExternalUrl($this->getUrl());
        
        $doc = $this->getRecipePage($this->getUrl());
        $xpath = new DOMXpath($doc);
        
        try {
            // TODO
        } catch (Exception $e) {
            // do nothing
        }
        
        return $recipe;
    }
    
    public function getUrl() {
        return $this->_url_STR;
    }
    
    public function setUrl($url) {
        parent::verifyType($url, "string");
        $this->_url_STR = $url;
    }
    
    public function getSiteName() {
        return $this->_siteName_STR;
    }
    
    public function getSiteLogo() {
        return $this->_siteLogoUrl_STR;
    }

}
