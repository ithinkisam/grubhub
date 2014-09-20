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
    
    public static function joinTable($table1, $table2, $joinConditions) {
        $conditions = array();
        foreach ($joinConditions as $key1 => $key2) {
            $conditions[] = $key1 . "=" . $key2;
        }
        $onString = implode(" AND ", $conditions);
        return $table1 . " JOIN " . $table2 . " ON " . $onString;
    }
    
    public static function joinTables($table1, $table2, $table3, $joinCondition1, $joinCondition2) {
        $join = DataAccessConfig::joinTable($table1, $table2, $joinCondition1);
        return DataAccessConfig::joinTable($join, $table3, $joinCondition2);
    }
    
    public static function authData() {
        $data = new stdClass;
        $data->tableName = "authorization";
        $data->userGroup = $data->tableName . ".user_group";
        $data->controller = $data->tableName . ".controller";
        $data->action = $data->tableName . ".action";
        return $data;
    }
    
    public static function commentData() {
        $data = new stdClass;
        $data->tableName = "comment";
        $data->commentId = $data->tableName . ".comment_id";
        $data->recipeId = $data->tableName . ".recipe_id";
        $data->description = $data->tableName . ".description";
        $data->createDate = $data->tableName . ".create_date";
        $data->updateDate = $data->tableName . ".update_date";
        return $data;
    }
    
    public static function directionData() {
        $data = new stdClass;
        $data->tableName = "direction";
        $data->directionId = $data->tableName . ".direction_id";
        $data->recipeId = $data->tableName . ".recipe_id";
        $data->stepNumber = $data->tableName . ".step_number";
        $data->description = $data->tableName . ".description";
        return $data;
    }
    
    public static function hubData() {
        $data = new stdClass;
        $data->tableName = "hub";
        $data->hubId = $data->tableName . ".hub_id";
        $data->name = $data->tableName . ".name";
        return $data;
    }
    
    public static function ingredientData() {
        $data = new stdClass;
        $data->tableName = "ingredient";
        $data->ingredientId = $data->tableName . ".ingredient_id";
        $data->recipeId = $data->tableName . ".recipe_id";
        $data->amountMin = $data->tableName . ".amount_min";
        $data->amountMax = $data->tableName . ".amount_max";
        $data->amountUnit = $data->tableName . ".amount_unit";
        $data->description = $data->tableName . ".description";
        return $data;
    }
    
    public static function ingredientUnitDomainData() {
        $data = new stdClass;
        $data->tableName = "ingredient_unit_domain";
        $data->ingredientUnitId = $data->tableName . ".ingredient_unit_id";
        $data->description = $data->tableName . ".description";
        $data->descriptionPlural = $data->tableName . ".description_pl";
        return $data;
    }
    
    public static function keywordData() {
        $data = new stdClass;
        $data->tableName = "keyword";
        $data->keywordId = $data->tableName . ".keyword";
        $data->recipeId = $data->tableName . ".recipe_id";
        $data->description = $data->tableName . ".description";
        return $data;
    }
    
    public static function messageData() {
        $data = new stdClass;
        $data->tableName = "message";
        $data->messageId = $data->tableName . ".message_id";
        $data->messageText = $data->tableName . ".message_text";
        return $data;
    }
    
    public static function noteData() {
        $data = new stdClass;
        $data->tableName = "note";
        $data->noteId = $data->tableName . "note_id";
        $data->recipeId = $data->tableName . "recipe_id";
        $data->description = $data->tableName . "description";
        return $data;
    }
    
    public static function nutritionFactData() {
        $data = new stdClass;
        $data->tableName = "nutrition_fact";
        $data->nutritionFactId = $data->tableName . ".nutrition_fact_id";
        $data->recipeId = $data->tableName . ".recipe_id";
        $data->description = $data->tableName . ".description";
        return $data;
    }
    
    public static function recipeData() {
        $data = new stdClass;
        $data->tableName = "recipe";
        $data->recipeId = $data->tableName . ".recipe_id";
        $data->name = $data->tableName . ".name";
        $data->description = $data->tableName . ".description";
        $data->imageUrl = $data->tableName . ".image_url";
        return $data;
    }
    
    public static function recipeDetailData() {
        $data = new stdClass;
        $data->tableName = "recipe_detail";
        $data->recipeId = $data->tableName . ".recipe_id";
        $data->yieldMin = $data->tableName . ".yield_min";
        $data->yieldMax = $data->tableName . ".yield_max";
        $data->yieldUnit = $data->tableName . ".yield_unit";
        $data->servingSizeMin = $data->tableName . ".serving_size_min";
        $data->servingSizeMax = $data->tableName . ".serving_size_max";
        $data->servingSizeUnit = $data->tableName . ".serving_size_unit";
        $data->prepTimeMin = $data->tableName . ".prep_time_min";
        $data->prepTimeMax = $data->tableName . ".prep_time_max";
        $data->prepTimeUnit = $data->tableName . ".prep_time_unit";
        $data->cookTimeMin = $data->tableName . ".cook_time_min";
        $data->cookTimeMax = $data->tableName . ".cook_time_max";
        $data->cookTimeUnit = $data->tableName . ".cook_time_unit";
        $data->ovenTempMin = $data->tableName . ".oven_temp_min";
        $data->ovenTempMax = $data->tableName . ".oven_temp_max";
        $data->ovenTempUnit = $data->tableName . ".oven_temp_unit";
        $data->rating = $data->tableName . ".rating";
        $data->externalUrl = $data->tableName . ".external_url";
        $data->createDate = $data->tableName . ".create_date";
        $data->updateDate = $data->tableName . ".update_date";
        return $data;
    }
    
    public static function servingUnitDomainData() {
        $data = new stdClass;
        $data->tableName = "serving_unit_domain";
        $data->servingUnitId = $data->tableName . ".serving_unit_id";
        $data->description = $data->tableName . ".description";
        $data->descriptionPlural = $data->tableName . ".description_pl";
        return $data;
    }
    
    public static function tempUnitDomainData() {
        $data = new stdClass;
        $data->tableName = "temperature_unit_domain";
        $data->tempUnitId = $data->tableName . ".temperature_unit_id";
        $data->description = $data->tableName . ".description";
        $data->descriptionPlural = $data->tableName . ".description_pl";
        return $data;
    }
    
    public static function timeUnitDomainData() {
        $data = new stdClass;
        $data->tableName = "time_unit_domain";
        $data->timeUnitId = $data->tableName . ".time_unit_id";
        $data->description = $data->tableName . ".description";
        $data->descriptionPlural = $data->tableName . ".description_pl";
        return $data;
    }
    
    public static function userData() {
        $data = new stdClass;
        $data->tableName = "user";
        $data->userId = $data->tableName . ".user_id";
        $data->username = $data->tableName . ".username";
        $data->password = $data->tableName . ".password";
        $data->selectAll = array($data->userId,
                                 $data->username,
                                 $data->password);
        return $data;
    }
    
    public static function userDetailData() {
        $data = new stdClass;
        $data->tableName = "user_detail";
        $data->userId = $data->tableName . ".user_id";
        $data->email = $data->tableName . ".email";
        $data->displayName = $data->tableName . ".display_name";
        $data->welcomePage = $data->tableName . ".welcome_page";
        $data->shareKey = $data->tableName . ".share_key";
        $data->joinDate = $data->tableName . ".join_date";
        $data->selectAll = array($data->userId,
                                 $data->email,
                                 $data->displayName,
                                 $data->welcomePage,
                                 $data->shareKey,
                                 $data->joinDate);
        return $data;
    }
    
    public static function userGroupDomainData() {
        $data = new stdClass;
        $data->tableName = "user_group_domain";
        $data->userGroup = $data->tableName . ".user_group";
        return $data;
    }
    
    public static function userGroupRelationData() {
        $data = new stdClass;
        $data->tableName = "user_group_relation";
        $data->userId = $data->tableName . ".user_id";
        $data->userGroup = $data->tableName . ".user_group";
        return $data;
    }
    
    public static function userRecipeRelationData() {
        $data = new stdClass;
        $data->tableName = "user_recipe_relation";
        $data->userId = $data->tableName . ".user_id";
        $data->recipeId = $data->tableName . ".recipe_id";
        return $data;
    }
    
    public static function yieldUnitDomainData() {
        $data = new stdClass;
        $data->tableName = "yield_unit_domain";
        $data->yieldUnitId = $data->tableName . ".yield_unit_id";
        $data->description = $data->tableName . ".description";
        $data->descriptionPlural = $data->tableName . ".description_pl";
        return $data;
    }

}
