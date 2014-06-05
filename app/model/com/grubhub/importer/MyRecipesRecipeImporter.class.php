<?php

class MyRecipesRecipeImporter extends RecipeImporter {

    private $_url_STR;
    private $_siteName_STR;
    private $_siteLogoUrl_STR;
    
    function __construct() {
        $this->_siteName_STR = "My Recipes";
        
        $page = new Page();
        $this->_siteLogoUrl_STR = $page->getImage("recipe-importers/myrecipes.png");
    }

    public function getRecipe() {
        $recipe = new Recipe("New Recipe - My Recipes");
        $recipe->setExternalUrl($this->getUrl());
        
        $doc = $this->getRecipePage($this->getUrl());
        $xpath = new DOMXpath($doc);
        
        try {
        
            $json_str = $doc->getElementById("recipe_json")->nodeValue;
            $json_str = str_replace("var this_recipe = ", "", $json_str);
            $json_str = str_replace(".recipe;", "", $json_str);
            $json_obj = json_decode($json_str);
            $json_recipe = $json_obj->recipe;
            
            // Scrub name
            $name = $json_recipe->name;
            $recipe->setName($name);
            
            // Scrub image
            $image = $json_recipe->expanded_image_url;
            $recipe->setImageUrl($image);
            
            // Scrub description
			$description = $json_recipe->editorial_recipe_data->seo_description;
			$recipe->setDescription($description);
            
            // Scrub prep time
            
            
            // Scrub total time/unit
			
			// Scrub yield
			$yield = intval($json_recipe->editorial_recipe_data->servings_yield);
			$recipe->setYield(new Range($yield));
            
            // Scrub serving size

			// Scrub ingredients
			$json_ingredients = $json_recipe->ingredients;
			foreach ($json_ingredients as $json_ingredient) {
				$amount = new Range(parent::fractionToDecimal($json_ingredient->amount));
				$unit = CookingUnit::toValue($json_ingredient->units);
				$desc = $json_ingredient->name;
				$ingredient = new Ingredient($amount, $unit, $desc);
				$recipe->addIngredient($ingredient);
			}
            
			// Scrub directions
            $direction_nodes = $xpath->query('//ol[@itemprop="instructions"]/li');
            for ($i = 0; $i < $direction_nodes->length; $i++) {
                $desc = $direction_nodes->item($i)->nodeValue;
                if (preg_match("/([\d]+)\./", $desc, $matches)) {
                    $step = $matches[1];
                    $desc = trim(substr($desc, strlen($step) + 1));
                    $direction = new Direction(intval($step), $desc);
                } else {
                    $direction = new Direction($i + 1, $desc);
                }
                $recipe->addDirection($direction);
            }
            
			// Scrub nutrition facts
			$nutritionalInfo = $json_recipe->editorial_recipe_data->nutritional_info;
            foreach ($nutritionalInfo as $nInfo) {
                $fact = $nInfo->amount .
                        $nInfo->unit . " " .
                        $nInfo->type;
                $fact = preg_replace("/\s\s+/", " ", $fact);
                $recipe->addNutritionFact($fact);
            }
            
            // Scrub rating
            $rating = $json_recipe->average_rating;
            $recipe->setRating(intval($rating));
        
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
