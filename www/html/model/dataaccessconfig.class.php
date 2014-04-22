<?php

/**
 *  This configuration class serves as an interface between
 *  the data access methods and the underlying data tables.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 *      04/13/2014 (SDB) - Update recipe data for addition
 *                      of 'yield' field
 */
class DataAccessConfig extends ObjectBase {
        
    public static function authData() {
        $data = new stdClass;
        $data->name = "Authorization";
        $data->all = "*";
        $data->page = "page";
        $data->userGroup = "userGroup";
        return $data;
    }
    
    public static function userData() {
        $data = new stdClass;
        $data->name = "Users";
        $data->all = "*";
        $data->username = "username";
        $data->password = "password";
        $data->email = "email";
        $data->displayName = "displayName";
        $data->welcomePage = "welcomePage";
        $data->shareKey = "shareKey";
        $data->joinTime = "joinTime";
        return $data;
    }
    
    public static function groupData() {
        $data = new stdClass;
        $data->name = "UserGroups";
        $data->all = "*";
        $data->userGroup = "userGroup";
        return $data;
    }
    
    public static function userGroupData() {
        $data = new stdClass;
        $data->name = "UserGroupRelation";
        $data->all = "*";
        $data->username = "username";
        $data->userGroup = "userGroup";
        return $data;
    }
    
    public static function recipeData() {
        $data = new stdClass;
        $data->name = "Recipes";
        $data->all = "*";
        $data->id = "id";
        $data->username = "username";
        $data->recipeName = "name";
        $data->description = "description";
        $data->imageUrl = "imageUrl";
        $data->yieldMin = "yieldMin";
        $data->yieldMax = "yieldMax";
        $data->servingSizeMin = "servingSizeMin";
        $data->servingSizeMax = "servingSizeMax";
        $data->prepTimeMin = "prepTimeMin";
        $data->prepTimeMax = "prepTimeMax";
        $data->prepTimeUnit = "prepTimeUnit";
        $data->cookTimeMin = "cookTimeMin";
        $data->cookTimeMax = "cookTimeMax";
        $data->cookTimeUnit = "cookTimeUnit";
        $data->ovenTempMin = "ovenTempMin";
        $data->ovenTempMax = "ovenTempMax";
        $data->ovenTempUnit = "ovenTempUnit";
        $data->rating = "rating";
        $data->externalUrl = "externalUrl";
        $data->createTime = "createTime";
        $data->updateTime = "updateTime";
        return $data;
    }
    
    public static function directionData() {
        $data = new stdClass;
        $data->name = "Directions";
        $data->all = "*";
        $data->username = "username";
        $data->recipeId = "recipeId";
        $data->stepNumber = "stepNumber";
        $data->description = "description";
        return $data;
    }
    
    public static function ingredientData() {
        $data = new stdClass;
        $data->name = "Ingredients";
        $data->all = "*";
        $data->username = "username";
        $data->recipeId = "recipeId";
        $data->id = "id";
        $data->amountMin = "amountMin";
        $data->amountMax = "amountMax";
        $data->unit = "unit";
        $data->description = "description";
        return $data;
    }
    
    public static function nutritionFactData() {
        $data = new stdClass;
        $data->name = "NutritionFacts";
        $data->all = "*";
        $data->username = "username";
        $data->recipeId = "recipeId";
        $data->description = "description";
        return $data;
    }
    
    public static function noteData() {
        $data = new stdClass;
        $data->name = "Notes";
        $data->all = "*";
        $data->username = "username";
        $data->recipeId = "recipeId";
        $data->description = "description";
        return $data;
    }
    
    public static function keywordData() {
        $data = new stdClass;
        $data->name = "Keywords";
        $data->all = "*";
        $data->username = "username";
        $data->recipeId = "recipeId";
        $data->description = "description";
        return $data;
    }
    
    public static function commentData() {
        $data = new stdClass;
        $data->name = "Comments";
        $data->all = "*";
        $data->username = "username";
        $data->recipeId = "recipeId";
        $data->description = "description";
        $data->timestamp = "timestamp";
        return $data;
    }
    
    public static function hubData() {
        $data = new stdClass;
        $data->name = "Hubs";
        $data->all = "*";
        $data->username = "username";
        $data->hub = "hub";
        return $data;
    }
    
    public static function recipeHubData() {
        $data = new stdClass;
        $data->name = "RecipeHubRelation";
        $data->all = "*";
        $data->username = "username";
        $data->hub = "hub";
        $data->recipeId = "recipeId";
        return $data;
    }
    
    public static function pageMenuData() {
        $data = new stdClass;
        $data->name = "PageMenu";
        $data->all = "*";
        $data->id = "id";
        $data->entryName = "name";
        $data->url = "url";
        $data->hoverText = "hoverText";
        $data->orientation = "orientation";
        $data->guestVis = "guestVis";
        $data->userVis = "userVis";
        $data->adminVis = "adminVis";
        $data->submenus = "submenus";
        return $data;
    }
    
    public static function messageData() {
        $data = new stdClass;
        $data->name = "Messages";
        $data->all = "*";
        $data->code = "code";
        $data->message = "message";
        return $data;
    }

}
