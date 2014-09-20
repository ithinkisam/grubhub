<?php

/**
 *  User object mapper.
 *
 *  Change History:
 *      08/16/2014 (SDB) - Initial creation.
 */
class UserMapper implements Mapper {

    public static function mapResult($result) {
        $config = DataAccessConfig::userData();
        
        $userId = $result[$config->userId];
        $username = $result[$config->username];
        $password = $result[$config->password];
        
        $user = new User($username, $password);
        $user->setUserId($userId);
        return $user;
    }

}
