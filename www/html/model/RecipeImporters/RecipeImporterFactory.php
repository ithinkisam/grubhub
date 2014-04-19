<?php

class RecipeImporterFactory {

    public static function getRecipeImporter($url) {
        $lowerCaseUrl = strtolower($url);
        $recipeImporter = new GenericRecipeImporter();
        
        if (strpos($lowerCaseUrl, "addapinch.com") !== false) {
            $recipeImporter = new AddAPinchRecipeImporter();
        } else if (strpos($lowerCaseUrl, "allrecipes.com") !== false) {
            $recipeImporter = new AllRecipesRecipeImporter();
        } else if (strpos($lowerCaseUrl, "epicurious.com") !== false) {
            $recipeImporter = new EpicuriousRecipeImporter();
        } else if (strpos($lowerCaseUrl, "food.com") !== false) {
            $recipeImporter = new FoodRecipeImporter();
        } else if (strpos($lowerCaseUrl, "foodnetwork.com") !== false) {
            $recipeImporter = new FoodNetworkRecipeImporter();
        } else if (strpos($lowerCaseUrl, "ithinkisam.com") !== false) {
            $recipeImporter = new IThinkISamRecipeImporter();
        } else if (strpos($lowerCaseUrl, "simplyrecipes.com") !== false) {
            $recipeImporter = new SimplyRecipesRecipeImporter();
        } else if (strpos($lowerCaseUrl, "myrecipes.com") !== false) {
            $recipeImporter = new MyRecipesRecipeImporter();
        } else if (strpos($lowerCaseUrl, "realsimple.com") !== false) {
            $recipeImporter = new RealSimpleRecipeImporter();
        } else if (strpos($lowerCaseUrl, "relish.com") !== false) {
            $recipeImporter = new RelishRecipeImporter();
        } else if (strpos($lowerCaseUrl, "womansday.com") !== false) {
            $recipeImporter = new WomansDayRecipeImporter();
        }
        
        $recipeImporter->setUrl($url);
        return $recipeImporter;
    }

}
