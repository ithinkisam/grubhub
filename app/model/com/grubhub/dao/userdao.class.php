<?php

/**
 *  This data access class houses methods for accessing user
 *  information.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs.
 *      08/16/2014 (SDB) - Refactored for DA changes.
 */
class UserDAO extends DatabaseUser {

    /**
     *  Retrieves information for the user with the given
     *  username and password combination.
     *
     *  @param {string} username The username string to target
     *  @param {string} password The password string to target
     *  @return {User} A User object containing basic user information
     *  @throws Exception if username/password combo is not found
     */
    public function getUser($username, $password) {
        parent::verifyType($username, "string");
        parent::verifyType($password, "string");
        $username = strtolower($username);
        $table = DataAccessConfig::userData();
        $values = $table->selectAll;
        $target = array($table->username => "'" . $username . "'",
                        $table->password => "'" . $password . "'");
        $users = $this->selectRows($table->tableName, $values, $target, NULL, new UserMapper());
        
        if (count($users) != 1) {
            throw new Exception(MessageConfig::USER_PASSWORD_NOT_FOUND);
        }
        return $users[0];
    }
    
    /**
     *  Retrieves detailed information about a user.
     *
     *  @param {string} username The username string to target
     *  @param {string} password The password string to target
     *  @return {User} A User object containing detailed user data
     *  @throws Exception if the username is not found
     */
    public function getUserDetail($username, $password) {
        parent::verifyType($username, "string");
        $username = strtolower($username);
        $userTable = DataAccessConfig::userData();
        $userDetailTable = DataAccessConfig::userDetailData();
        $table = DataAccessConfig::joinTable(
                $userTable->tableName,
                $userDetailTable->tableName,
                array($userTable->userId => $userDetailTable->userId));
        $values = array_merge($userTable->selectAll,
                              $userDetailTable->selectAll);
        $target = array($userTable->username => "'" . $username . "'",
                        $userTable->password => "'" . $password . "'");
        $users = $this->selectRows($table, $values, $target, NULL, new UserDetailMapper());
        
        if (count($users) != 1) {
            throw new Exception(MessageConfig::USER_PASSWORD_NOT_FOUND);
        }
        return $users[0];
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
        $userTable = DataAccessConfig::userData();
        $userDetailTable = DataAccessConfig::userDetailData();
        $table = DataAccessConfig::joinTable(
                $userTable->tableName,
                $userDetailTable->tableName,
                array($userTable->userId => $userDetailTable->userId)
            );
        $values = array(
                $userDetailTable->email => "'" . $user->getEmail() . "'",
                $userDetailTable->displayName => "'" . $user->getDisplayName() . "'",
                $userDetailTable->welcomePage => "'" . $user->getWelcomePage() . "'",
                $userDetailTable->shareKey => "'" . $user->getShareKey() . "'"
            );
        $target = array(
                $userTable->username => "'" . strtolower($user->getUsername()) . "'",
                $userTable->password => "'" . $user->getPassword() . "'"
            );
        $result = $this->updateTable($table, $values, $target);
        
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
                "'" . strtolower($user->getUsername()) . "'",
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
                $table->username => "'" . strtolower($user->getUsername()) . "'",
                $table->password => "'" . $user->getPassword() . "'"
            );
        $result = $this->deleteRows($table->tableName, $target);
        
        if ($result !== true) {
            // try to resolve
            if (!$this->usernameExists($user->getUsername())) {
                throw new Exception(MessageConfig::USER_NOT_FOUND);
            }
            throw new Exception(MessageConfig::USER_ERROR_DELETE);
        }
        return $result; // true
    }
    
    public function isAuthorized($user, $controller, $action) {
        parent::verifyType($user, "User");
        $userTable = DataAccessConfig::userData();
        $userGroupRelation = DataAccessConfig::userGroupRelationData();
        $authTable = DataAccessConfig::authData();
        $table = DataAccessConfig::joinTables(
                $userTable->tableName,
                $userGroupRelation->tableName,
                $authTable->tableName,
                array($userTable->userId => $userGroupRelation->userId),
                array($userGroupRelation->userGroup => $authTable->userGroup)
            );
        $values = array($userTable->username);
        $target = array(
                $userTable->username => "'" . strtolower($user->getUsername),
                $userTable->password => "'" . $user->getPassword() . "'",
                $authTable->controller => "'" . $controller . "'",
                $authTable->action=> "'" . $action . "'"
            );
        return $this->selectRows($table, $values, $target);
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
        $values = array($table->userId);
        $target = array($table->username => "'" . $username . "'");
        $result = $this->selectRows($table->tableName, $values, $target);
        
        return count($result) == 1;
    }

}
