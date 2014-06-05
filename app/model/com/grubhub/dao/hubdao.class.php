<?php

/**
 *  This data access class contains methods for accessing hub data.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
class HubDAO extends DatabaseUser {

    /**
     *  Adds a new hub for the specified user.
     *
     *  @param {User} user A User object describing the user to receive
     *              the new hub.
     *  @param {string} hub A string describing the hub to add.
     *  @return {boolean} true if the hub was added successfully.
     *  @throws Exception if an error occurred while adding the hub.
     */
    public function addHub($user, $hub) {
        parent::verifyType($user, "User");
        parent::verifyType($hub, "string");
        $table = DataAccessConfig::hubData();
        $values = array(
                $table->username => "'" . $user->getUsername() . "'",
                $table->hub => "'" . $hub . "'"
            );
        $result = $this->insertRow($table->name, $values);
        if ($result !== true) {
            throw new Exception(MessageConfig::HUB_ERROR_ADD);
        }
        return $result; // true
    }
    
    /**
     *  Deletes an existing hub for the specified user.
     *
     *  @param {User} user The user to target.
     *  @param {string} hub The hub to delete.
     *  @return {boolean} true if the hub was deleted successfully.
     *  @throws Exception if an error occurred deleting the hub.
     */
    public function deleteHub($user, $hub) {
        parent::verifyType($user, "User");
        parent::verifyType($hub, "string");
        $table = DataAccessConfig::hubData();
        $target = array(
                $table->username => "'" . $user->getUsername() . "'",
                $table->hub => "'" . $hub . "'"
            );
        $result = $this->deleteRows($table->name, $target);
        if ($result !== true) {
            throw new Exception(MessageConfig::HUB_ERROR_DELETE);
        }
        return $result; // true
    }
    
    /**
     *  Updates a hub name.
     *
     *  @param {User} user The user to target.
     *  @param {string} oldHub The current hub name.
     *  @param {string} newHub The new hub name to use.
     *  @return {boolean} true if the hub was updated successfully.
     *  @throws Exception if an error occurred while updating the hub.
     */
    public function updateHub($user, $oldHub, $newHub) {
        parent::verifyType($user, "User");
        parent::verifyType($hub, "string");
        $table = DataAccessConfig::hubData();
        $values = array($table->hub => "'" . $newHub . "'");
        $target = array(
                $table->username => "'" . $user->getUsername() . "'",
                $table->hub => "'" . $oldHub . "'"
            );
        $result = $this->updateTable($table->name, $values, $target);
        if ($result !== true) {
            throw new Exception(MessageConfig::HUB_ERROR_EDIT);
        }
        return $result; // true
    }
    
    /**
     *  Retrieves all hubs associated with the specified user.
     *
     *  @param {User} user The user to target.
     *  @return {array:string} A list of hubs.
     *  @throws Exception if an error occurred while retrieving hubs.
     */
    public function getUserHubs($user) {
        parent::verifyType($user, "User");
        $table = DataAccessConfig::hubData();
        $values = array($table->hub);
        $target = array(
                $table->username => "'" . $user->getUsername() . "'"
            );
        $result = $this->selectRows($table->name, $values, $target);
        if ($result === false) {
            throw new Exception(MessageConfig::HUB_ERROR_RETRIEVING);
        }
        
        $hubs = array();
        foreach ($result as $entry) {
            $hubs[] = $entry[$table->hub];
        }
        return $hubs;
    }
    
    /**
     *  Retrieves all recipes for the specified user contained in the
     *  specified hub.
     *
     *  @param {User} user A User object containing user information.
     *  @param {string} hub A string describing the hub to use.
     *  @return {array:Recipe} An array of Recipe objects.
     *  @throws Exception if an error occurred retrieving the recipes.
     */
    public function getRecipesByHub($user, $hub) {
        parent::verifyType($user, "User");
        parent::verifyType($hub, "string");
        $table = DataAccessConfig::recipeHubData();
        $values = array($table->recipeId);
        $target = array(
                $table->username => "'" . $user->getUsername() . "'",
                $table->hub => "'" . $hub . "'"
            );
        $result = $this->selectRows($table->name, $values, $target);
        if ($result === false) {
            throw new Exception(MessageConfig::HUB_ERROR_RETRIEVING);
        }
        
        $recipeDao = new RecipeDAO();
        $recipes = array();
        foreach ($result as $entry) {
            $recipes[] = $recipeDao->getRecipe($user,
                    $entry[$table->recipeId]);
        }
        return $recipes;
    }
    
    /**
     *  Retrieves all recipes for a specified user that are not
     *  categorized in a hub for that user.
     *
     *  @param {User} user The user to target.
     *  @return {array:Recipe} A list of recipes.
     *  @throws Exception if an error occurred while retrieving the
     *          list of recipes.
     */
    public function getUncategorizedRecipes($user) {
        parent::verifyType($user, "User");
        $values = array("'" . $user->getUsername() . "'");
        $result = $this->multiValuedStoredProcedure(
                "p_getUncategorizedRecipes", $value);
        
        // $subQuery = "SELECT recipeId " .
                    // "FROM " . DataAccessConfig::recipeHubData()->name . " " .
                    // "WHERE username = '" . $user->getUsername() . "'";
        // $customQuery = "SELECT id " .
                       // "FROM " . DataAccessConfig::recipeData()->name . " " .
                       // "WHERE username = '" . $user->getUsername() . "'" .
                       // "AND id NOT IN (" . $subQuery . ")";
        // $result = $this->sendQuery($customQuery);
        if ($result === false) {
            throw new Exception(MessageConfig::HUB_ERROR_RETRIEVING_UNCAT_RECIPES);
        }
        
        $recipes = array();
        foreach ($result as $entry) {
            $recipes[] = $this->getRecipe($user,
                    $entry[DataAccessConfig::recipeData()->id]
                );
        }
        return $recipes;
    }
    
    /**
     *  Retrieves all hubs associated with a specified recipe.
     *
     *  @param {User} user The user to target.
     *  @param {Recipe} recipe The recipe to target.
     *  @return {array:string} A list of hubs associated with the
     *          specified user/recipe.
     *  @throws Exception if an error occurred while retrieving the
     *          hubs.
     */
    public function getRecipeHubs($user, $recipe) {
        parent::verifyType($user, "User");
        parent::verifyType($recipe, "Recipe");
        $table = DataAccessConfig::recipeHubData();
        $values = array($table->hub);
        $target = array(
                $table->username => "'" . $user->getUsername() . "'",
                $table->recipeId => "'" . $recipe->getId() . "'"
            );
        $result = $this->selectRows($table->name, $values, $target);
        if ($result === false) {
            throw new Exception(MessageConfig::HUB_ERROR_RETRIEVING_RECIPE_HUBS);
        }
        
        $hubs = array();
        foreach ($result as $entry) {
            $hubs[] = $entry[$table->hub];
        }
        return $hubs;
    }
    
    /**
     *  Add a recipe to a hub.
     *
     *  @param {User} user The user to target.
     *  @param {Recipe} recipe The recipe to add to a hub.
     *  @param {string} hub The hub to add the recipe to.
     *  @return {boolean} true if the recipe was successfully added
     *          to the hub.
     *  @throws Exception if an error occured while adding the recipe
     *          to the hub.
     */
    public function addRecipeToHub($user, $recipe, $hub) {
        parent::verifyType($user, "User");
        parent::verifyType($recipe, "Recipe");
        parent::verifyType($hub, "string");
        $table = DataAccessConfig::recipeHubData();
        $values = array(
                $table->username => "'" . $user->getUsername() . "'",
                $table->hub => "'" . $hub . "'",
                $table->recipeId => "'" . $recipe->getId() . "'"
            );
        $result = $this->insertRows($table->name, $values);
        if ($result !== true) {
            throw new Exception(MessageConfig::HUB_ERROR_ADD_RECIPE);
        }
        return $result; // true;
    }
    
    /**
     *  Deletes a recipe from a hub.
     *
     *  @param {User} user The user to target.
     *  @param {Recipe} recipe The recipe to remove from the hub.
     *  @param {string} hub The hub to remove the recipe from.
     *  @return {boolean} true if the recipe was removed successfully.
     *  @throws Exception if an error occurred while removing the
     *          recipe from the hub.
     */
    public function deleteRecipeFromHub($user, $recipe, $hub) {
        parent::verifyType($user, "User");
        parent::verifyType($recipe, "Recipe");
        parent::verifyType($hub, "string");
        $table = DataAccessConfig::recipeHubData();
        $target = array(
                $table->username => "'" . $user->getUsername() . "'",
                $table->hub => "'" . $hub . "'",
                $table->recipeId => "'" . $recipe->getId() . "'"
            );
        $result = $this->deleteRows($table->name, $target);
        if ($result !== true) {
            throw new Exception(MessageConfig::HUB_ERROR_REMOVE_RECIPE);
        }
        return $result; // true;
    }

}
