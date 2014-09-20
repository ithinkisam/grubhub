<?php

/**
 *  User object mapper.
 *
 *  Change History:
 *      08/16/2014 (SDB) - Initial creation.
 */
class UserDetailMapper implements Mapper {

    public static function mapResult($result) {
        $basicConfig = DataAccessConfig::userData();
        $detailConfig = DataAccessConfig::userDetailData();
        
        $userId = $result[$basicConfig->userId];
        $username = $result[$basicConfig->username];
        $password = $result[$basicConfig->password];
        $email = $result[$detailConfig->email];
        $displayName = $result[$detailConfig->displayName];
        $welcomePage = $result[$detailConfig->welcomePage];
        $shareKey = $result[$detailConfig->shareKey];
        $joinDate = new DateTime($result[$detailConfig->joinDate]);
        
        $user = new User($username, $password);
        $user->setUserId($userId);
        $user->setEmail($email);
        if (!is_null($displayName)) {
            $user->setDisplayName($displayName);
        } else {
            $user->setDisplayName($username);
        }
        $user->setWelcomePage($welcomePage);
        $user->setShareKey($shareKey);
        $user->setJoinDate($joinDate);
        
        return $user;
    }

}
