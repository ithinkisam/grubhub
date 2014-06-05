<?php

/**
 *  This data access class contains methods for making queries against
 *  the database.
 *
 *  Change History:
 *      02/27/2014 (SDB) - New class
 */
class SearchDAO extends DatabaseUser {

    public function findHubs($username, $q) {
        parent::verifyType($username, "string");
        parent::verifyType($q, "string");
        $table = DataAccessConfig::hubData();
        $values = array($table->hub);
        $target = array($table->username => "'" . $username . "'");
        $result = $this->selectRows($table->name, $values, $target);
        if ($result === false) {
            return array();
        }
        
        $lowerQ = strtolower(trim($q));
        if ($lowerQ === "") {
            return array();
        }
        
        $hubs = array();
        foreach ($result as $entry) {
            $hub = strtolower($entry[$table->hub]);
            if (strpos($hub, $lowerQ) !== false) {
                $hubs[] = $entry[$table->hub];
            }
        }
        return $hubs;
    }
    
    public function findRecipes($username, $q) {
        parent::verifyType($username, "string");
        parent::verifyType($q, "string");
        $table = DataAccessConfig::recipeData();
        $values = array($table->all);
        $target = array($table->username => "'" . $username . "'");
        $result = $this->selectRows($table->name, $values, $target);
        if ($result === false) {
            return array();
        }
        
        $lowerQ = strtolower(trim($q));
        if ($lowerQ === "") {
            return array();
        }
        
        $recipes = array();
        foreach ($result as $entry) {
            $recipeName = strtolower($entry[$table->recipeName]);
            if (strpos($recipeName, $lowerQ) !== false) {
                $recipe = new Recipe($entry[$table->recipeName]);
                $recipe->setRecipeId($entry[$table->id]);
                $recipe->setUserId($entry[$table->username]);
                $recipe->setDescription($entry[$table->description]);
                $recipe->setImageUrl($entry[$table->imageUrl]);
                $recipe->setServingSize(new Range(
                            $entry[$table->servingSizeMin],
                            $entry[$table->servingSizeMax]));
                $recipes[] = $recipe;
            }
        }
        return $recipes;
    }
    
    public function findUsers($q) {
        parent::verifyType($q, "string");
        $table = DataAccessConfig::userData();
        $values = array($table->all);
        $target = array();
        $result = $this->selectRows($table->name, $values, $target);
        if ($result === false) {
            return array();
        }
        
        $lowerQ = strtolower(trim($q));
        if ($lowerQ === "") {
            return array();
        }
        
        $users = array();
        foreach ($result as $entry) {
            $username = strtolower($entry[$table->username]);
            $displayName = strtolower($entry[$table->displayName]);
            $email = strtolower($entry[$table->email]);
            if ((strpos($username, $lowerQ) !== false)
                    || (strpos($displayName, $lowerQ) !== false)
                    || (strpos($email, $lowerQ) !== false)) {
                $user = new User($entry[$table->username],
                                "******", // password
                                $entry[$table->email]);
                if ($entry[$table->displayName] !== null) {
                    $user->setDisplayName($entry[$table->displayName]);
                } else {
                    $user->setDisplayName($entry[$table->username]);
                }
                $user->setJoinTime(intval($entry[$table->joinTime]));
                $users[] = $user;
            }
        }
        
        return $users;
    }

}

?>