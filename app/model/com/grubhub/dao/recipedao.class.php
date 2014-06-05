<?php

/**
 *  This data access class contains methods for accessing recipe
 *  data.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 *      04/13/2014 (SDB) - Added yield field to getRecipe and
 *                  updateRecipe functions
 */
class RecipeDAO extends DatabaseUser {
    
    /**
     *  Retrieves a recipe object.
     *
     *  @param {User} user The user to target.
     *  @param {string} recipeId The id of the recipe to target.
     *  @param {resource} dbhandle=false Optional database
     *          connection handler.
     *  @return {Recipe} The recipe.
     *  @throws Exception if the recipe is not found
     */
    public function getRecipe($user, $recipeId, $dbhandle=false) {
        parent::verifyType($user, "User");
        parent::verifyType($recipeId, "string");
        if ($dbhandle === false) {
            $connection = $this->openConnection();
        } else {
            $connection = $dbhandle;
        }
    
        $table = DataAccessConfig::recipeData();
        $values = array($table->all);
        $target = array(
                $table->id => "'" . $recipeId . "'",
                $table->username => "'" . strtoupper($user->getUsername()) . "'"
            );
        $result = $this->selectRows($table->name, $values, $target,
                NULL, $connection);
        
        if (count($result) != 1) {
            throw new Exception(MessageConfig::RECIPE_NOT_FOUND);
        }
        
        $entry = $result[0];
        $recipe = new Recipe($entry[$table->recipeName]);
        $recipe->setRecipeId($entry[$table->id]);
        $recipe->setUserId($entry[$table->username]);
        $recipe->setDescription($entry[$table->description]);
        $recipe->setImageUrl($entry[$table->imageUrl]);
        $yield = new Range(
                $entry[$table->yieldMin],
                $entry[$table->yieldMax]
            );
        $recipe->setYield($yield);
        $servingSize = new Range(
                $entry[$table->servingSizeMin],
                $entry[$table->servingSizeMax]
            );
        $recipe->setServingSize($servingSize);
        $prepRange = new Range(
                $entry[$table->prepTimeMin],
                $entry[$table->prepTimeMax]
            );
        $prepTime = new Time($prepRange,
                intval($entry[$table->prepTimeUnit])
            );
        $recipe->setPrepTime($prepTime);
        $cookRange = new Range(
                $entry[$table->cookTimeMin],
                $entry[$table->cookTimeMax]
            );
        $cookTime = new Time($cookRange,
                intval($entry[$table->cookTimeUnit])
            );
        $recipe->setCookTime($cookTime);
        $ovenRange = new Range(
                $entry[$table->ovenTempMin],
                $entry[$table->ovenTempMax]
            );
        $ovenTemp = new Temperature($ovenRange,
                intval($entry[$table->ovenTempUnit])
            );
        $recipe->setOvenTemp($ovenTemp);
        $recipe->setRating(intval($entry[$table->rating]));
        $recipe->setExternalUrl($entry[$table->externalUrl]);
        $recipe->setCreateTime(intval($entry[$table->createTime]));
        $recipe->setUpdateTime(intval($entry[$table->updateTime]));

        /* Gather Ingredient list */
		$table = DataAccessConfig::ingredientData();
		$values = array(
                $table->id,
                $table->amountMin,
                $table->amountMax,
                $table->unit,
                $table->description
            );
		$target = array(
                $table->username => "'" . $entry[$table->username] . "'",
                $table->recipeId => "'" . $recipeId . "'"
            );
		$result = $this->selectRows($table->name, $values, $target,
                NULL, $connection);

		foreach ($result as $entry) {
			$ing_range = new Range(
                    $entry[$table->amountMin],
                    $entry[$table->amountMax]
                );
			$ingredient = new Ingredient($ing_range,
										 intval($entry[$table->unit]),
										 $entry[$table->description]);
            $ingredient->setId(intval($entry[$table->id]));
			$recipe->addIngredient($ingredient);
		}
        
        /* Gather Direction list */
		$table = DataAccessConfig::directionData();
		$values = array($table->stepNumber, $table->description);
		$target = array(
                $table->username => "'" . $entry[$table->username] . "'",
                $table->recipeId => "'" . $recipeId . "'"
            );
		$result = $this->selectRows($table->name, $values, $target,
                NULL, $connection);

		foreach ($result as $entry) {
			$direction = new Direction(
                    $entry[$table->stepNumber],
                    $entry[$table->description]
                );
			$recipe->addDirection($direction);
		}
        
        /* Gather nutrition facts */
        $table = DataAccessConfig::nutritionFactData();
        $values = array($table->description);
        $target = array(
                $table->username => "'" . $entry[$table->username] . "'",
                $table->recipeId => "'" . $recipeId . "'"
            );
        $result = $this->selectRows($table->name, $values, $target,
                NULL, $connection);
        foreach ($result as $entry) {
            $recipe->addNutritionFact($entry[$table->description]);
        }

        /* Gather notes */
		$table = DataAccessConfig::noteData();
        $values = array($table->description);
        $target = array(
                $table->username => "'" . $entry[$table->username] . "'",
                $table->recipeId => "'" . $recipeId . "'"
            );
        $result = $this->selectRows($table->name, $values, $target,
                NULL, $connection);
        foreach ($result as $entry) {
            $recipe->addNote($entry[$table->description]);
        }

        /* Gather keywords */
		$table = DataAccessConfig::keywordData();
        $values = array($table->description);
        $target = array(
                $table->username => "'" . $entry[$table->username] . "'",
                $table->recipeId => "'" . $recipeId . "'"
            );
        $result = $this->selectRows($table->name, $values, $target,
                NULL, $connection);
        foreach ($result as $entry) {
            $recipe->addKeyword($entry[$table->description]);
        }

        /* Gather comments */
		$table = DataAccessConfig::commentData();
        $values = array($table->description, $table->timestamp);
        $target = array(
                $table->username => "'" . $entry[$table->username] . "'",
                $table->recipeId => "'" . $recipeId . "'"
            );
        $result = $this->selectRows($table->name, $values, $target,
                NULL, $connection);
        foreach ($result as $entry) {
            $comment = new Comment(
                    $entry[$table->description],
                    intval($entry[$table->timestamp])
                );
            $recipe->addComment($comment);
        }
        
        if ($dbhandle === false) {
            $this->closeConnection($connection);
        }

        return $recipe;
    }
    
    /**
     *  Updates a recipe.
     *
     *  @param {User} user The user to target.
     *  @param {Recipe} recipe The recipe to update, containing
     *          updated information.
     *  @return {boolean} true if the recipe was updated successfully.
     *  @throws Exception if an error occurred while trying to update
     *          the recipe.
     */
    public function updateRecipe($user, $recipe) {
        parent::verifyType($user, "User");
        parent::verifyType($recipe, "Recipe");
        $connection = $this->startTransaction();
        
        // Use a series of transaction to delete and re-add the
        // recipe rather than trying to update each field.
        $result = $this->deleteRecipe($user, $recipe, $connection);
        if ($result !== true) {
            $this->rollback($connection);
            throw new Exception(MessageConfig::RECIPE_ERROR_EDIT);
        }
        
        $result = $this->addRecipe($user, $recipe, $connection);
        $this->commit($connection);
		Logger::debug(get_class($this), __FUNCTION__,
                "Successfully updated recipe " . $recipe->getId());
        return $result; // true
    }
    
    /**
     *  Adds a new recipe to the system for the specified user.
     *
     *  @param {User} user The user adding the new recipe.
     *  @param {Recipe} recipe The recipe to add.
     *  @param {resource} dbhandle=false Optional database
     *          connection handler.
     *  @return {boolean} true if the recipe was added successfully.
     *  @throws Exception if an error occurred adding the recipe or
     *          any of its components.
     */
    public function addRecipe($user, $recipe, $dbhandle=false) {
        parent::verifyType($user, "User");
        parent::verifyType($recipe, "Recipe");
        if ($dbhandle === false) {
            $connection = $this->startTransaction();
        } else {
            $connection = $dbhandle;
        }
        
        $table = DataAccessConfig::recipeData();
        $values = array(
                $table->id => "'" . $recipe->getRecipeId() . "'",
                $table->username => "'" . strtoupper($user->getUsername()) . "'",
                $table->recipeName => "'" . $recipe->getName() . "'",
                $table->description => "'" . $recipe->getDescription() . "'",
                $table->imageUrl => "'" . $recipe->getImageUrl() . "'",
                $table->yieldMin => $recipe->getYield()->getMin(),
                $table->yieldMax => $recipe->getYield()->getMax(),
                $table->servingSizeMin => $recipe->getServingSize()->getMin(),
                $table->servingSizeMax => $recipe->getServingSize()->getMax(),
                $table->prepTimeMin => $recipe->getPrepTime()->getRange()->getMin(),
                $table->prepTimeMax => $recipe->getPrepTime()->getRange()->getMax(),
                $table->prepTimeUnit => $recipe->getPrepTime()->getUnit(),
                $table->cookTimeMin => $recipe->getCookTime()->getRange()->getMin(),
                $table->cookTimeMax => $recipe->getCookTime()->getRange()->getMax(),
                $table->cookTimeUnit => $recipe->getCookTime()->getUnit(),
                $table->ovenTempMin => $recipe->getOvenTemp()->getRange()->getMin(),
                $table->ovenTempMax => $recipe->getOvenTemp()->getRange()->getMax(),
                $table->ovenTempUnit => $recipe->getOvenTemp()->getUnit(),
                $table->rating => $recipe->getRating(),
                $table->externalUrl => "'" . $recipe->getExternalUrl() . "'",
                $table->createTime => $recipe->getCreateTime(),
                $table->updateTime => $recipe->getUpdateTime()
            );
        $result = $this->insertRow($table->name, $values, $connection);
        if ($result !== true) {
            $this->rollback($connection);
            throw new Exception(MessageConfig::RECIPE_ERROR_ADD);
        }
        
        $table = DataAccessConfig::ingredientData();
        foreach ($recipe->getIngredientList() as $ingredient) {
            $values = array(
                    $table->username => "'" . $user->getUsername() . "'",
                    $table->recipeId => "'" . $recipe->getRecipeId() . "'",
                    $table->id => $recipe->getId(),
                    $table->amountMin => $ingredient->getAmount()->getMin(),
                    $table->amountMax => $ingredient->getAmount()->getMax(),
                    $table->unit => $ingredient->getUnit(),
                    $table->description => "'" . $ingredient->getDescription() . "'"
                );
            $result = $this->insertRow($table->name, $values, 
                    $connection);
            if ($result !== true) {
                $this->rollback($connection);
                throw new Exception(MessageConfig::RECIPE_ERROR_ADD_INGREDIENT);
            }
        }
        
        $table = DataAccessConfig::directionData();
        foreach ($recipe->getDirectionList() as $direction) {
            $values = array(
                    $table->username => "'" . $user->getUsername() . "'",
                    $table->recipeId => "'" . $recipe->getRecipeId() . "'",
                    $table->stepNumber => $direction->getStepNumber(),
                    $table->description => "'" . $direction->getDescription() . "'"
            );
            $result = $this->insertRow($table->name, $values,
                    $connection);
            if ($result !== true) {
                $this->rollback($connection);
                throw new Exception(MessageConfig::RECIPE_ERROR_ADD_DIRECTION);
            }
        }
        
        $table = DataAccessConfig::commentData();
        foreach ($recipe->getCommentList() as $comment) {
            $values = array(
                    $table->username => "'" . $user->getUsername() . "'",
                    $table->recipeId => "'" . $recipe->getRecipeId() . "'",
                    $table->description => "'" . $comment->getDescription() . "'",
                    $table->timestamp => $comment->getTimestamp()
                );
            $result = $this->insertRow($table->name, $values,
                    $connection);
            if ($result !== true) {
                $this->rollback($connection);
                throw new Exception(MessageConfig::RECIPE_ERROR_ADD_COMMENT);
            }
        }
        
        $table = DataAccessConfig::keywordData();
        foreach ($recipe->getKeywordList() as $keyword) {
            $values = array(
                    $table->username => "'" . $user->getUsername() . "'",
                    $table->recipeId => "'" . $recipe->getRecipeId() . "'",
                    $table->description => "'" . $keyword . "'"
                );
            $result = $this->insertRow($table->name, $values, $connection);
            if ($result !== true) {
                $this->rollback($connection);
                throw new Exception(MessageConfig::RECIPE_ERROR_ADD_KEYWORD);
            }
        }
        
        $table = DataAccessConfig::noteData();
        foreach ($recipe->getNoteList() as $note) {
            $values = array(
                    $table->username => "'" . $user->getUsername() . "'",
                    $table->recipeId => "'" . $recipe->getRecipeId() . "'",
                    $table->description => "'" . $note . "'"
                );
            $result = $this->insertRow($table->name, $values, $connection);
            if ($result !== true) {
                $this->rollback($connection);
                throw new Exception(MessageConfig::RECIPE_ERROR_ADD_NOTE);
            }
        }
        
        $table = DataAccessConfig::nutritionFactData();
        foreach ($recipe->getNutritionFactList() as $nutritionFact) {
            $values = array(
                    $table->username => "'" . $user->getUsername() . "'",
                    $table->recipeId => "'" . $recipe->getRecipeId() . "'",
                    $table->description => "'" . $nutritionFact . "'"
                );
            $result = $this->insertRow($table->name, $values, $connection);
            if ($result !== true) {
                $this->rollback($connection);
                throw new Exception(MessageConfig::RECIPE_ERROR_ADD_NUTRITION_FACT);
            }
        }
        
        if ($dbhandle === false) {
            $this->commit($connection);
        }
        Logger::debug(get_class($this), __FUNCTION__,
                "Successfully added recipe " . $recipe->getRecipeId());
        return $result; // true
    }
    
    /**
     *  Deletes a recipe from the system for the specified user.
     *
     *  @param {User} user The user deleting a recipe.
     *  @param {Recipe} recipe The recipe to delete.
     *  @param {resource} dbhandle=false Optional database
     *          connection handler.
     *  @return {boolean} true if the recipe was deleted successfully.
     *  @throws Exception if an error occurred while attempting to
     *          delete the recipe.
     */
    public function deleteRecipe($user, $recipe, $dbhandle=false) {
        parent::verifyType($user, "User");
        parent::verifyType($recipe, "Recipe");
        if ($dbhandle === false) {
            $connection = $this->startTransaction();
        } else {
            $connection = $dbhandle;
        }
        
        $table = DataAccessConfig::recipeData();
        $target = array(
                $table->id => "'" . $recipe->getRecipeId() . "'",
                $table->username => "'" . $user->getUsername() . "'"
            );
        $result = $this->deleteRows($table->name, $target, $connection);
        if ($result !== true) {
            $this->rollback($connection);
            throw new Exception(MessageConfig::RECIPE_ERROR_DELETE);
        }
        
        if ($dbhandle === false) {
            $this->commit($connection);
        }
        Logger::debug(get_class($this), __FUNCTION__,
                "Successful deleted recipe " . $recipe->getRecipeId());
        return $result; // true
    }
    
    /**
     *  Retrieves all recipes for the specified user.
     *
     *  @param {User} user The user to target.
     *  @return {array:Recipe} A list of recipes.
     *  @throws Exception if an error occurred while retrieving a
     *          recipe.
     */
    public function getRecipes($user) {
        parent::verifyType($user, "User");
        $recipeIds = $this->getRecipeIds($user);
        $connection = $this->openConnection();
        $recipes = array();
        foreach ($recipeIds as $recipeId) {
            $recipes[] = $this->getRecipe($user, $recipeId, $connection);
        }
        $this->closeConnection($connection);
        
        usort($recipes, array("Recipe", "compareTo"));
        return $recipes;
    }
    
    /**
     *  Retrieves the IDs for all recipes for the specified user.
     *
     *  @param {User} user The user to target.
     *  @return {array:string} A list of recipe IDs.
     *  @throws Exception if an error occurred while attempting to
     *          retrieve the recipe IDs.
     */
    public function getRecipeIds($user) {
        parent::verifyType($user, "User");
        $table = DataAccessConfig::recipeData();
        $values = array($table->id);
        $target = array(
                $table->username => "'" . $user->getUsername() . "'"
            );
        $result = $this->selectRows($table->name, $values, $target);
        
        if ($result === false) {
            throw new Exception(MessageConfig::RECIPES_NOT_FOUND);
        }
        $recipeIds = array();
        foreach ($result as $entry) {
            $recipeIds[] = $entry[$table->id];
        }
        return $recipeIds;
    }
    
    /**
     *  Retrieves a random recipe for the specified user. The optional
     *  $n parameter allows the user to provide the number of recipes
     *  they would like (default of 1).
     *
     *  @param {User} user The user to target.
     *  @param {integer} n=1 The number of recipes to retrieve.
     *  @return {array:Recipe} n random recipes for the specified
     *          user.    
     */
    public function getRandomRecipe($user, $n=1) {
        parent::verifyType($user, "User");
        parent::verifyType($user, "integer");
        $recipeIds = $this->getRecipeIds($user);
        $subset = parent::selectSubset($recipeIds, $n);
        
        $recipes = array();
        foreach ($subset as $recipeId) {
            $recipes[] = $this->getRecipe($user, $recipeId);
        }
        return $recipes;
    }
    
    /**
     *  Retrieves the <code>n</code> most recent recipes added for
     *  the specified user.
     *
     *  @param {User} user The user to target.
     *  @param {integer} n The number of recipes to retrieve.
     *  @return {array:Recipe} A list of the n most recent recipes.
     *  @throws Exception if an error occurred attempting to retrieve
     *          the recipes.
     */
    public function getMostRecentNRecipes($user, $n) {
        parent::verifyType($user, "User");
        parent::verifyType($n, "integer");
        
        if ($n < 1) {
            return array();
        }
        
        $table = DataAccessConfig::recipeData();
        $values = array($table->id);
        $target = array(
                $table->username => "'" . $user->getUsername() . "'"
            );
        $orderby = array($table->createTime,
                parent::ORDER_BY_DESC);
        
        $result = $this->selectRows($table, $value, $target, $orderby);
        if ($result === false) {
            throw new Exception(MessageConfig::RECIPES_NOT_FOUND);
        }
        $recipeIds = array();
        foreach ($result as $entry) {
            $recipeIds = $entry[$table->id];
            if (count($recipeIds) === $n) {
                break;
            }
        }
        
        $recipes = array();
        foreach ($subset as $recipeId) {
            $recipes[] = $this->getRecipe($user, $recipeId);
        }
        return $recipes;
    }

}
