<?php

/**
 *  This utility class provides methods for formatting recipes
 *  to be output to an page (HTML, print, etc.).
 *
 *  Change History:
 *      02/02/2014 (SDB) - Initial creation
 */
class RecipeBuilder extends ObjectBase {

    public static function buildStandardRecipeCard($recipe) {
        $recipeCardTemplate = new RecipeCardTemplate();
        $recipeCardTemplate->setName($recipe->getName());
        $recipeCardTemplate->setDescription($recipe->getDescription());
        $recipeCardTemplate->setImageUrl($recipe->getImageUrl());
        $recipeCardTemplate->setKeywordList($recipe->getKeywordList());
        $recipeCardTemplate->setServingSize($recipe->getServingSize());
        $recipeCardTemplate->setPrepTime($recipe->getPrepTime());
        $recipeCardTemplate->setCookTime($recipe->getCookTime());
        $recipeCardTemplate->setTotalTime($recipe->getTotalTime());
        $recipeCardTemplate->setRating($recipe->getRating());
        $recipeCardTemplate->setExternalUrl($recipe->getExternalUrl());
        
        $page = new Page();
        $recipeCardTemplate->setViewUrl($page->getViewRecipe($recipe->getRecipeId()));
        $recipeCardTemplate->setEditUrl($page->getEditRecipe($recipe->getRecipeId()));
        
        return $recipeCardTemplate->compile();
    }

    public static function buildStandardRecipeHeader($recipe) {
        $recipeHeaderTemplate = new RecipeHeaderTemplate();
        $recipeHeaderTemplate->setName($recipe->getName());
        $recipeHeaderTemplate->setDescription($recipe->getDescription());
        $recipeHeaderTemplate->setImageUrl($recipe->getImageUrl());
        $recipeHeaderTemplate->setKeywordList($recipe->getKeywordList());
        $recipeHeaderTemplate->setServingSize($recipe->getServingSize());
        $recipeHeaderTemplate->setPrepTime($recipe->getPrepTime());
        $recipeHeaderTemplate->setCookTime($recipe->getCookTime());
        $recipeHeaderTemplate->setTotalTime($recipe->getTotalTime());
        $recipeHeaderTemplate->setRating($recipe->getRating());
        $recipeHeaderTemplate->setExternalUrl($recipe->getExternalUrl());
        
        return $recipeHeaderTemplate->compile();
    }
    
    public static function buildStandardHubCard($hub) {
        $hubCardTemplate = new HubCardTemplate();
        $hubCardTemplate->setName($hub);
        
        return $hubCardTemplate->compile();
    }
    
}
