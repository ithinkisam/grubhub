<?php

/**
 *  This bean class represents a recipe (duh).
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 *      04/13/2014 (SDB) - Added 'yield' field
 */
 class Recipe extends ObjectBase implements JsonSerializable, I_Comparable {
 
    /* Private default values */
    const DEFAULT_INT = 0;
    const DEFAULT_STR = "";
    const RATING_LIMIT = 5;
    const RECIPE_ID_LENGTH = 20;
    
    /* Private instance data */
    private $_recipeId_STR;
    private $_userId_STR;
    private $_name_STR;
    private $_description_STR;
    private $_imageUrl_STR;
    private $_ingredientList_ING;
    private $_directionList_DIR;
    private $_nutritionFactList_STR;
    private $_noteList_STR;
    private $_keywordList_STR;
    private $_commentList_COM;
    private $_yield_RNG;
    private $_servingSize_RNG;
    private $_prepTime_TIM;
    private $_cookTime_TIM;
    private $_totalTime_TIM;
    private $_ovenTemp_TMP;
    private $_rating_INT;
    private $_externalUrl_STR;
    
    private $_CREATE_TIME_INT;
    private $_UPDATE_TIME_INT;
    
    function __construct($name) {
        $this->setRecipeId($this->randomString(self::RECIPE_ID_LENGTH));
        $this->setUserId(self::DEFAULT_STR);
        $this->setName($name);
        $this->setDescription(self::DEFAULT_STR);
        $this->setImageUrl(self::DEFAULT_STR);
        $this->setIngredientList(array());
        $this->setDirectionList(array());
        $this->setNutritionFactList(array());
        $this->setNoteList(array());
        $this->setKeywordList(array());
        $this->setCommentList(array());
        $this->setYield(new Range(0));
        $this->setServingSize(new Range(0));
        $this->setPrepTime(new Time(new Range(0), TimeUnit::NONE));
        $this->setCookTime(new Time(new Range(0), TimeUnit::NONE));
        $this->setTotalTime(new Time(new Range(0), TimeUnit::NONE));
        $this->setOvenTemp(new Temperature(new Range(0), TemperatureUnit::FAHRENHEIT));
        $this->setRating(self::DEFAULT_INT);
        $this->setExternalUrl(self::DEFAULT_STR);
        
        $this->_CREATE_TIME_INT = time();
        $this->_UPDATE_TIME_INT = time();
    }
    
    /* Specialty Functions */
    public function addIngredient($ingredient) {
        parent::verifyType($ingredient, "Ingredient");
        $this->_ingredientList_ING[] = $ingredient;
        $this->updated();
    }
    
    public function removeIngredient($ingredient) {
        parent::verifyType($ingredient, "Ingredient");
        $ingredients = $this->getIngredientList();
        for ($i = 0; $i < count($ingredients); $i++) {
            if ($ingredients[$i]->equals($ingredient)) {
                unset($ingredients[$i]);
            }
        }
        $this->setIngredientList(array_values($ingredients));
    }
    
    public function removeIngredientAt($index) {
        parent::verifyType($index, "integer");
        parent::verifyRange($index, 0, count($this->_ingredientList_ING));
        unset($this->_ingredientList_ING[$index]);
        $this->setIngredientList(array_values($this->_ingredientList_ING));
    }
    
    public function addDirection($direction) {
        parent::verifyType($direction, "Direction");
        $this->_directionList_DIR[] = $direction;
        $this->updated();
    }
    
    public function removeDirection($direction) {
        parent::verifyType($direction, "Direction");
        $directions = $this->getDirectionList();
        for ($i = 0; $i < count($directions); $i++) {
            if ($directions[$i]->equals($direction)) {
                unset($directions[$i]);
            }
        }
        $this->setDirectionList(array_values($directions));
    }
    
    public function removeDirectionAt($index) {
        parent::verifyType($index, "integer");
        parent::verifyRange($index, 0, count($this->_directionList_DIR));
        unset($this->_directionList_DIR[$index]);
        $this->setDirectionList(array_values($this->_directionList_DIR));
    }
    
    public function addNutritionFact($nutritionFact) {
        parent::verifyType($nutritionFact, "string");
        $this->_nutritionFactList_STR[] = $nutritionFact;
        $this->updated();
    }
    
    public function removeNutritionFact($nutritionFact) {
        parent::verifyType($nutritionFact, "string");
        $nutritionFacts = $this->getNutritionFacts();
        for ($i = 0; $i < count($nutritionFacts); $i++) {
            if ($nutritionFacts[$i]->equals($nutritionFact)) {
                unset($nutritionFacts[$i]);
            }
        }
        $this->setNutritionFactList(array_values($nutritionFacts));
    }
    
    public function removeNutritionFactAt($index) {
        parent::verifyType($index, "integer");
        parent::verifyRange($index, 0, count($this->_nutritionFactList_DIR));
        unset($this->_nutritionFactList_DIR[$index]);
        $this->setNutritionFactList(array_values($this->_nutritionFactList_DIR));
    }
    
    public function addNote($note) {
        parent::verifyType($note, "string");
        $this->_noteList_STR[] = $note;
        $this->updated();
    }
    
    public function removeNote($note) {
        parent::verifyType($note, "string");
        $notes = $this->getNoteList();
        for ($i = 0; $i < count($notes); $i++) {
            if ($notes[$i]->equals($note)) {
                unset($notes[$i]);
            }
        }
        $this->setNoteList(array_values($notes));
    }
    
    public function removeNoteAt($index) {
        parent::verifyType($index, "integer");
        parent::verifyRange($index, 0, count($this->_noteList_STR));
        unset($this->_noteList_STR[$index]);
        $this->setNoteList(array_values($this->_noteList_STR));
    }
    
    public function addKeyword($keyword) {
        parent::verifyType($keyword, "string");
        $this->_keywordList_STR[] = $keyword;
        $this->updated();
    }
    
    public function removeKeyword($keyword) {
        parent::verifyType($keyword, "string");
        $keywords = $this->getKeywordList();
        for ($i = 0; $i < count($keywords); $i++) {
            if ($keywords[$i]->equals($keyword)) {
                unset($keywords[$i]);
            }
        }
        $this->setKeywordList(array_values($keywords));
    }
    
    public function removeKeywordAt($index) {
        parent::verifyType($index, "integer");
        parent::verifyRange($index, 0, count($this->_keywordList_STR));
        unset($this->_keywordList_STR[$index]);
        $this->setKeywordList(array_values($this->_keywordList_STR));
    }
    
    public function addComment($comment) {
        parent::verifyType($comment, "Comment");
        $this->_commentList_COM[] = $comment;
        $this->updated();
    }
    
    public function removeComment($comment) {
        parent::verifyType($comment, "Comment");
        $comments = $this->getCommentList();
        for ($i = 0; $i < count($comments); $i++) {
            if ($comments[$i]->equals($comment)) {
                unset($comments[$i]);
            }
        }
        $this->setCommentList(array_values($comments));
    }
    
    public function removeCommentAt($index) {
        parent::verifyType($index, "integer");
        parent::verifyRange($index, 0, count($this->_commentList_COM));
        unset($this->_commentList_COM[$index]);
        $this->setCommentList(array_values($this->_commentList_COM));
    }
    
    private function updated() {
        $this->_UPDATE_TIME = time() + (2 * 60 * 60);
    }
    
    /* Getters 'n Setters */
    public function getRecipeId() {
        return $this->_recipeId_STR;
    }
    
    public function setRecipeId($recipeId) {
        parent::verifyType($recipeId, "string");
        parent::verifyStringLength($recipeId, self::RECIPE_ID_LENGTH);
        $this->_recipeId_STR = $recipeId;
        $this->updated();
    }
    
    public function getUserId() {
        return $this->_userId_STR;
    }
    
    public function setUserId($user) {
        parent::verifyType($user, "string");
        $this->_userId_STR = $user;
        $this->updated();
    }
    
    public function getName() {
        return $this->_name_STR;
    }
    
    public function setName($name) {
        parent::verifyType($name, "string");
        parent::verifyRange(strlen($name), 1, self::INFINITY);
        $this->_name_STR = $name;
        $this->updated();
    }
    
    public function getDescription() {
        return $this->_description_STR;
    }
    
    public function setDescription($description) {
        parent::verifyType($description, "string");
        $this->_description_STR = $description;
        $this->updated();
    }
    
    public function getImageUrl() {
        return $this->_imageUrl_STR;
    }
    
    public function setImageUrl($imageUrl) {
        parent::verifyType($imageUrl, "string");
        $this->_imageUrl_STR = $imageUrl;
        $this->updated();
    }
    
    public function getIngredientList() {
        return $this->_ingredientList_ING;
    }
    
    public function setIngredientList($ingredientList) {
        parent::verifyType($ingredientList, "array", "Ingredient");
        $this->_ingredientList_ING = $ingredientList;
        $this->updated();
    }
    
    public function getDirectionList() {
        return $this->_directionList_DIR;
    }
    
    public function setDirectionList($directionList) {
        parent::verifyType($directionList, "array", "Direction");
        $this->_directionList_DIR = $directionList;
        $this->updated();
    }
    
    public function getNutritionFactList() {
        return $this->_nutritionFactList_STR;
    }
    
    public function setNutritionFactList($nutritionFactList) {
        parent::verifyType($nutritionFactList, "array", "string");
        $this->_nutritionFactList_STR = $nutritionFactList;
        $this->updated();
    }
    
    public function getNoteList() {
        return $this->_noteList_STR;
    }
    
    public function setNoteList($noteList) {
        parent::verifyType($noteList, "array", "string");
        $this->_noteList_STR = $noteList;
        $this->updated();
    }
    
    public function getKeywordList() {
        return $this->_keywordList_STR;
    }
    
    public function setKeywordList($keywordList) {
        parent::verifyType($keywordList, "array", "string");
        $this->_keywordList_STR = $keywordList;
        $this->updated();
    }
    
    public function getCommentList() {
        return $this->_commentList_COM;
    }
    
    public function setCommentList($commentList) {
        parent::verifyType($commentList, "array", "Comment");
        $this->_commentList_COM = $commentList;
        $this->updated();
    }
    
    public function getYield() {
        return $this->_yield_RNG;
    }
    
    public function setYield($yield) {
        parent::verifyType($yield, "Range");
        $this->_yield_RNG = $yield;
        $this->updated();
    }
    
    public function getServingSize() {
        return $this->_servingSize_RNG;
    }
    
    public function setServingSize($servingSize) {
        parent::verifyType($servingSize, "Range");
        $this->_servingSize_RNG = $servingSize;
        $this->updated();
    }
    
    public function getPrepTime() {
        return $this->_prepTime_TIM;
    }
    
    public function setPrepTime($prepTime) {
        parent::verifyType($prepTime, "Time");
        $this->_prepTime_TIM = $prepTime;
        $this->updated();
    }
    
    public function getCookTime() {
        return $this->_cookTime_TIM;
    }
    
    public function setCookTime($cookTime) {
        parent::verifyType($cookTime, "Time");
        $this->_cookTime_TIM = $cookTime;
        $this->updated();
    }
    
    public function getTotalTime() {
        return $this->_totalTime_TIM;
    }
    
    public function setTotalTime($totalTime) {
        parent::verifyType($totalTime, "Time");
        $this->_totalTime_TIM = $totalTime;
        $this->updated();
    }
    
    public function getOvenTemp() {
        return $this->_ovenTemp_TMP;
    }
    
    public function setOvenTemp($ovenTemp) {
        parent::verifyType($ovenTemp, "Temperature");
        $this->_ovenTemp_TMP = $ovenTemp;
        $this->updated();
    }
    
    public function getRating() {
        return $this->_rating_INT;
    }
    
    public function setRating($rating) {
        parent::verifyType($rating, "integer");
        parent::verifyRange($rating, 0, self::RATING_LIMIT);
        $this->_rating_INT = $rating;
        $this->updated();
    }
    
    public function getExternalUrl() {
        return $this->_externalUrl_STR;
    }
    
    public function setExternalUrl($externalUrl) {
        parent::verifyType($externalUrl, "string");
        $this->_externalUrl_STR = $externalUrl;
        $this->updated();
    }
    
    public function getCreateTime() {
        return $this->_CREATE_TIME_INT;
    }
    
    public function setCreateTime($createTime) {
        parent::verifyType($createTime, "integer");
        $this->_CREATE_TIME_INT = $createTime;
    }
    
    public function getUpdateTime() {
        return $this->_UPDATE_TIME_INT;
    }
    
    public function setUpdateTime($updateTime) {
        parent::verifyType($updateTime, "integer");
        $this->_UPDATE_TIME_INT = $updateTime;
    }
    
    public function __toString() {
        $fields = array();
        $fields[] = "recipeId=" . $this->getRecipeId();
        $fields[] = "user=" . $this->getUserId();
        $fields[] = "name=" . $this->getName();
        $fields[] = "description=" . $this->getDescription();
        $fields[] = "imageUrl=" . $this->getImageUrl();
        
        $ingredients = array();
        foreach ($this->getIngredientList() as $ingredient) {
            $ingredients[] = $ingredient->__toString();
        }
        $fields[] = "ingredients=" . implode(",", $ingredients);
        
        $directions = array();
        foreach ($this->getDirectionList() as $direction) {
            $directions[] = $direction->__toString();
        }
        $fields[] = "directions=" . implode(",", $directions);
        
        $fields[] = "nutritionFacts=" . implode(",", $this->getNutritionFactList());
        $fields[] = "notes=" . implode(",", $this->getNoteList());
        $fields[] = "keywords=" . implode(",", $this->getKeywordList());
        
        $comments = array();
        foreach ($this->getCommentList() as $comment) {
            $comments[] = $comment->__toString();
        }
        $fields[] = "comments=" . implode(",", $comments);
        
        $fields[] = "yield=" . $this->getYield();
        $fields[] = "servingSize=" . $this->getServingSize();
        $fields[] = "prepTime=" . $this->getPrepTime();
        $fields[] = "cookTime=" . $this->getCookTime();
        $fields[] = "totalTime=" . $this->getTotalTime();
        $fields[] = "ovenTemp=" . $this->getOvenTemp();
        $fields[] = "rating=" . $this->getRating();
        $fields[] = "externalUrl=" . $this->getExternalUrl();
        $fields[] = "createTime=" . $this->getCreateTime();
        $fields[] = "updateTime=" . $this->getUpdateTime();
        
        return "Recipe[" . implode("::", $fields) . "]";
    }
    
    public function equals($recipe) {
        parent::verifyType($recipe, "Recipe");
        return ($this->getName() === $recipe->getName()
            && $this->getDescription() === $recipe->getDescription()
            && $this->getIngredientList() === $recipe->getIngredientList()
            && $this->getDirectionList() === $recipe->getDirectionList()
            && $this->getNutritionFactList() === $recipe->getNutritionFactList()
            && $this->getPrepTime() === $recipe->getPrepTime()
            && $this->getCookTime() === $recipe->getCookTime()
            && $this->getTotalTime() === $recipe->getTotalTime()
            && $this->getOvenTemp() === $recipe->getOvenTemp());
    }
    
    /**
     *  Compares two recipes for sorting purposes only. Use equals when
     *  checking for strict equality.
     *
     *  @param {Recipe} thisRecipe The first recipe
     *  @param {Recipe} thatRecipe The second recipe
     */
    public static function compareTo($thisRecipe, $thatRecipe) {
        $objBase = new ObjectBase();
        $objBase->verifyType($thisRecipe, "Recipe");
        $objBase->verifyType($thatRecipe, "Recipe");
        return strcmp($thisRecipe->getName(), $thatRecipe->getName());
    }
    
    public function jsonSerialize() {
        $fields = array();
        $fields["recipeId"] = $this->getRecipeId();
        $fields["user"] = $this->getUserId();
        $fields["name"] = $this->getName();
        $fields["description"] = $this->getDescription();
        $fields["imageUrl"] = $this->getImageUrl();
        
        $ingredients = array();
        foreach ($this->getIngredientList() as $ingredient) {
            $ingredients[] = $ingredient->jsonSerialize();
        }
        $fields["ingredients"] = $ingredients;
        
        $directions = array();
        foreach ($this->getDirectionList() as $direction) {
            $directions[] = $direction->jsonSerialize();
        }
        $fields["directions"] = $directions;
        
        $fields["nutritionFacts"] = $this->getNutritionFactList();
        $fields["notes"] = $this->getNoteList();
        $fields["keywords"] = $this->getKeywordList();
        
        $comments = array();
        foreach ($this->getCommentList() as $comment) {
            $comments[] = $comment->jsonSerialize();
        }
        $fields["comments"] = $comments;
        
        $fields["yield"] = $this->getYield()->jsonSerialize();
        $fields["servingSize"] = $this->getServingSize()->jsonSerialize();
        $fields["prepTime"] = $this->getPrepTime()->jsonSerialize();
        $fields["cookTime"] = $this->getCookTime()->jsonSerialize();
        $fields["totalTime"] = $this->getTotalTime()->jsonSerialize();
        $fields["ovenTemp"] = $this->getOvenTemp()->jsonSerialize();
        $fields["rating"] = $this->getRating();
        $fields["externalUrl"] = $this->getExternalUrl();
        $fields["createTime"] = $this->getCreateTime();
        $fields["updateTime"] = $this->getUpdateTime();
        
        return $fields;
    }
 
 }
 