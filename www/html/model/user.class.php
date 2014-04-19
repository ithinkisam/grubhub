<?php

/**
 *  This bean class represents a system user.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
class User extends ObjectBase implements JsonSerializable, I_Comparable {

    private $_username_STR;
    private $_password_STR;
    private $_email_STR;
    private $_displayName_STR;
    private $_welcomePage_STR;
    private $_shareKey_STR;
    private $_joinTime_INT;
    
    /**
     *  Default constructor. Username, password and email are
     *  all required fields for a new User.
     */
    public function __construct($username, $password, $email) {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setEmail($email);
    }
    
    public function getUsername() {
        return $this->_username_STR;
    }
    
    public function setUsername($username) {
        parent::verifyType($username, "string");
        if (preg_match("/^\w[\w\d_]+$/", $username)) {
            $this->_username_STR = $username;
        } else {
            throw new Exception(MessageConfig::USER_INVALID_USERNAME);
        }
    }
    
    public function getPassword() {
        return $this->_password_STR;
    }
    
    public function setPassword($password) {
        parent::verifyType($password, "string");
        if (preg_match("/[\w\d!@#$%^&*?\.]+/", $password)) {
            $this->_password_STR = $password;
        } else {
            throw new Exception(MessageConfig::USER_INVALID_PASSWORD);
        }
    }
    
    public function getEmail() {
        return $this->_email_STR;
    }
    
    public function setEmail($email) {
        parent::verifyType($email, "string");
        $this->_email_STR = $email;
    }
    
    public function getDisplayName() {
        return $this->_displayName_STR;
    }
    
    public function setDisplayName($displayName) {
        parent::verifyType($displayName, "string");
        $this->_displayName_STR = $displayName;
    }
    
    public function getWelcomePage() {
        return $this->_welcomePage_STR;
    }
    
    public function setWelcomePage($welcomePage) {
        parent::verifyType($welcomePage, "string");
        $this->_welcomePage_STR = $welcomePage;
    }
    
    public function getShareKey() {
        return $this->_shareKey_STR;
    }
    
    public function setShareKey($shareKey) {
        parent::verifyType($shareKey, "string");
        $this->_shareKey_STR = $shareKey;
    }
    
    public function getJoinTime() {
        return $this->_joinTime_INT;
    }
    
    public function setJoinTime($joinTime) {
        parent::verifyType($joinTime, "integer");
        $this->_joinTime_INT = $joinTime;
    }
    
    public function __toString() {
        $fields = array();
        $fields[] = "username=" . $this->getUsername();
        $fields[] = "password=" . $this->getPassword();
        $fields[] = "email=" . $this->getEmail();
        $fields[] = "displayName=" . $this->getDisplayName();
        $fields[] = "welcomePage=" . $this->getWelcomePage();
        $fields[] = "shareKey=" . $this->getShareKey();
        $fields[] = "joinTime=" . $this->getJoinTime();
        
        return "User[" . implode("::", $fields) . "]";
    }
    
    public function equals($user) {
        parent::verifyType($user, "User");
        return $this->getUsername() === $user->getUsername();
    }
    
    public static function compareTo($thisUser, $thatUser) {
        $objBase = new ObjectBase();
        $objBase->verifyType($thisUser, "User");
        $objBase->verifyType($thatUser, "User");
        return strcmp($thisUser->getUsername(), $thatUser->getUsername());
    }
    
    public function jsonSerialize() {
        $fields = array();
        $fields["username"] = $this->getUsername();
        $fields["email"] = $this->getEmail();
        $fields["displayName"] = $this->getDisplayName();
        $fields["joinTime"] = $this->getJoinTime();
        return $fields;
    }

}
