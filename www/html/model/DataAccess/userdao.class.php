<?php

/**
 *  This data access class houses methods for accessing user
 *  information.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
class UserDAO extends DatabaseUser {

    /**
     *  Retrieves basic information about a user. Meant to service
     *  requests from one user about a different user.
     *
     *  @param {string} username The username string to target
     *  @return {User} A User object containing basic user data
     *  @throws Exception if the username is not found
     */
    public function getUserInfo($username) {
        parent::verifyType($username, "string");
        $username = strtoupper($username);
        $table = DataAccessConfig::userData();
        $values = array($table->all);
        $target = array($table->username => "'" . $username . "'");
        $result = $this->selectRows($table->name, $values, $target);
        
        if (count($result) != 1) {
            throw new Exception(MessageConfig::USER_PASSWORD_NOT_FOUND);
        }
        $entry = $result[0];
        $user = new User($entry[$table->username],
                         "*****", // not allowed to see password
                         $entry[$table->email]);
                         
        if ($entry[$table->displayName] !== null) {
            $user->setDisplayName($entry[$table->displayName]);
        } else {
            $user->setDisplayName($entry[$table->username]);
        }
        $user->setJoinTime(intval($entry[$table->joinTime]));
        
        return $user;
    }
    
    /**
     *  Retrieves information for the user with the given
     *  username and password combination.
     *
     *  @param {string} username The username string to target
     *  @param {string} password The password string to target
     *  @return {User} A User object containing the users information
     *  @throws Exception if username/password combo is not found
     */
    public function getUser($username, $password) {
        parent::verifyType($username, "string");
        parent::verifyType($password, "string");
        $username = strtoupper($username);
        $table = DataAccessConfig::userData();
        $values = array($table->all);
        $target = array(
                $table->username => "'" . $username . "'",
                $table->password => "'" . $password . "'"
            );
        $result = $this->selectRows($table->name, $values, $target);
        
        if (count($result) != 1) {
            throw new Exception(MessageConfig::USER_PASSWORD_NOT_FOUND);
        }
        $entry = $result[0];
        $user = new User($entry[$table->username],
                         $entry[$table->password],
                         $entry[$table->email]);
        if ($entry[$table->displayName] !== null) {
            $user->setDisplayName($entry[$table->displayName]);
        } else {
            $user->setDisplayName($entry[$table->username]);
        }
        if ($entry[$table->welcomePage] !== null) {
            $user->setWelcomePage($entry[$table->welcomePage]);
        }
        if ($entry[$table->shareKey] !== null) {
            $user->setShareKey($entry[$table->shareKey]);
        }
        $user->setJoinTime(intval($entry[$table->joinTime]));
        return $user;
    }
    
    /**
     *  Updates any user information that has been changed (usernames
     *  and passwords cannot be updated via this method).
     *
     *  @param {User} user A User object containing data to use for the
     *              update.
     *  @return {boolean} true if the update was successful
     *  @throws Exception if the update was not successful
     */
    public function updateUser($user) {
        parent::verifyType($user, "User");
        $table = DataAccessConfig::userData();
        $values = array(
                $table->email => "'" . $user->getEmail() . "'",
                $table->displayName => "'" . $user->getDisplayName() . "'",
                $table->welcomePage => "'" . $user->getWelcomePage() . "'",
                $table->shareKey => "'" . $user->getShareKey() . "'"
            );
        $target = array(
                $table->username => "'" . strtoupper($user->getUsername()) . "'",
                $table->password => "'" . $user->getPassword() . "'"
            );
        $result = $this->updateTable($table->name, $values, $target);
        
        if ($result !== true) {
            throw new Exception(MessageConfig::USER_NOT_FOUND);
        }
        return $result; // true
    }
    
    /**
     *  Adds a new user to the system.
     *
     *  @param {User} user A User object representing the new user
     *  @return {boolean} true if the user was added successfully
     *  @throws Exception if an error occurred while adding the user
     */
    public function addUser($user) {
        parent::verifyType($user, "User");
        $values = array(
                "'" . strtoupper($user->getUsername()) . "'",
                "'" . $user->getPassword() . "'",
                "'" . $user->getEmail() . "'",
                "'" . $user->getDisplayName() . "'",
                "'" . $user->getWelcomePage() . "'",
                "'" . $user->getShareKey() . "'"
            );
        $result = $this->singleValuedStoredProcedure(
                "p_addUser", $values);
        if ($result !== true) {
            throw new Exception(MessageConfig::USER_ERROR_ADD);
        }
        return $result;
    }
    
    /**
     *  Deletes a user from the system.
     *
     *  @param {User} user The User to delete from the system.
     *  @return {boolean} true if the delete was succesful.
     *  @throws Exception if User does not exist or if an error
     *          occurs during deletion (appropriate message code
     *          is included to help differentiate).
     */
    public function deleteUser($user) {
        parent::verifyType($user, "User");
        $table = DataAccessConfig::userData();
        $target = array(
                $table->username => "'" . strtoupper($user->getUsername()) . "'",
                $table->password => "'" . $user->getPassword() . "'"
            );
        $result = $this->deleteRows($table->name, $target);
        
        if ($result !== true) {
            // try to resolve
            if (!$this->usernameExists($user->getUsername())) {
                throw new Exception(MessageConfig::USER_NOT_FOUND);
            }
            throw new Exception(MessageConfig::USER_ERROR_DELETE);
        }
        return $result; // true
    }
    
    /**
     *  Whether the provided User is present in the system.
     *
     *  @param {User} user A User object containing information for the
     *              targetted user.
     *  @return {boolean} Whether or not the User is present in the system.
     */
    public function isUser($user) {
        parent::verifyType($user, "User");
        $table = DataAccessConfig::userData();
        $values = array("*");
        $target = array(
                $table->username => "'" . strtoupper($user->getUsername()) . "'",
                $table->password => "'" . $user->getPassword() . "'"
            );
        $result = $this->selectRows($table->name, $values, $target);
        
        if (count($result) == 1) {
            return true;
        }
        return false;
    }

    /**
     *  Retrieves a User object based on share key.
     *
     *  @param {string} shareKey A string
     *  @return {User} A User object corresponding to the user that provided
     *          the share key.
     *  @throws Exception if the share key is not valid.
     */
    public function getUserFromShareKey($shareKey) {
        parent::verifyType($shareKey, "string");
        $table = DataAccessConfig::userData();
        $values = array($table->username, $table->password);
        $target = array($table->shareKey => "'" . $shareKey . "'");
        $result = $this->selectRows($table->name, $values, $target);
        
        if (count($result) == 1) {
            $entry = $result[0];
            return $this->getUser($entry[$table->username],
                                  $entry[$table->password]
                                  );
        } else {
            throw new Exception(MessageConfig::USER_INVALID_SHARE_KEY);
        }
    }
    
    /*
     *  Whether a username exists in the system.
     *
     *  @param {string} username A string containing the username to check.
     *  @return {boolean} Whether the username is present in the system.
     */
    private function usernameExists($username) {
        parent::verifyType($username, "string");
        $table = DataAccessConfig::userData();
        $values = array($table->username);
        $target = array($table->username => "'" . $username . "'");
        $result = $this->selectRows($table->name, $values, $target);
        
        if (count($result) == 1) {
            return true;
        }
        return false;
    }

}
