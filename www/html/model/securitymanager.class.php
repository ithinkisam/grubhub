<?php

/**
 *  This class provides the methods for authorizing and
 *  authenticating users.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
class SecurityManager extends DatabaseUser {

    /**
     *  Authenticates a user based on the current session.
     *
     *  @param {array} session The current session.
     *  @throws Exception if the current user has not been
     *          authenticated.
     */
    public function authenticate($session) {
        $user = $session['USER'];
        $pass = $session['PASS'];

        if ($user == "") {
            $user = "GUEST";
            $pass = self::encrypt("guest");
			Logger::debug(get_class($this), __FUNCTION__, "Setting up guest session");
        }
        
        $table = DataAccessConfig::userData();
        $values = array("*");
        $target = array(
                $table->username => "'" . $user . "'",
                $table->password => "'" . $pass . "'"
            );
        $result = $this->selectRows($table->name, $values, $target);
        
        if ($result === false || $result === true || count($result) !== 1) {
            throw new Exception(MessageConfig::USER_NOT_FOUND);
        }
    }
    
    /**
     *  Checks whether the user in the provided session is authorized
     *  to acces the given page.
     *
     *  @param {array} session The current session.
     *  @param {string} page The page the user is trying to access.
     */
    public function authorize($session, $page) {
		$user = $session['USER'];

		if ($user == "") {
			$user = "guest";
			Logger::debug(get_class($this), __FUNCTION__, "Setting up guest session");
		}

		$table = DataAccessConfig::userGroupData();
		$values = array($table->userGroup);
		$target = array($table->username => "'" . $user . "'");
		$result = $this->selectRows($table->name, $values, $target);
		if (count($result) < 1) {
			throw new Exception(MessageConfig::USER_NOT_AUTHORIZED);
		}
		$groups = array();
		foreach ($result as $entry) {
			$groups[] = "'" . $entry[$table->userGroup] . "'";
		}

        $table = DataAccessConfig::authData();
        $values = array("*");
        $target = array($table->page => "'" . $page . "'",
                        "userGroup IN (" . implode(", ", $groups) . ") AND 'x'" => "'x'");
        $result = $this->selectRows($table->name, $values, $target);
        
        if (count($result) < 1) {
            throw new Exception(MessageConfig::USER_INSUFFICIENT_PRIVILEDGES);
        }
    }

    /**
     *  Checks whether the user for the current session is an admin.
     *
     *  @param {array} session The current session.
     *  @return true if the user is an administrator, false otherwise.
     */
	public function checkAdmin($session) {
		$user = $session['USER'];

		if ($user == "") {
			$user = "guest";
			Logger::debug(get_class($this), __FUNCTION__, "Setting up guest session");
		}

		$table = DataAccessConfig::userGroupData();
		$values = array($table->userGroup);
		$target = array(
                $table->username => "'" . $user . "'",
                $table->userGroup => "'ADMIN'"
            );
		$result = parent::selectRows($table->name, $values, $target);

		if (count($result) == 1) {
			return true;
		}
		return false;
	}
    
    /**
     *  Checks whether the user for the current session is a
     *  registered user.
     *
     *  @param {array} session The current session.
     *  @return true if the user is a registered user, false otherwise.
     */
    public function checkUserA($session) {
        $user = $session['USER'];

		if ($user == "") {
			$user = "guest";
		}

		$table = DataAccessConfig::userGroupData();
		$values = array($table->userGroup);
		$target = array(
                $table->username => "'" . $user . "'",
                $table->userGroup => "'USERA'"
            );
		$result = $this->selectRows($table->name, $values, $target);

		if (count($result) == 1) {
			return true;
		}
		return false;
    }

    /**
     *  Retrieves page menu entries viewable to the current user.
     *
     *  @param {array} session The current session.
     *  @return {array:PageMenuEntry} Menu entries viewable by the
     *          current user.
     */
	public function getPageMenuEntries($session) {
		$isGuest = false;
		$isUserA = false;
		$isAdmin = false;
		$user = $session['USER'];

		if ($user == "") {
			$user = "guest";
			$isGuest = true;
			Logger::debug(get_class($this), __FUNCTION__, "Setting up guest session");
		}

		$table = DataAccessConfig::userGroupData();
		$values = array($table->userGroup);
		$target = array($table->username => "'" . $user . "'");
		$result = $this->selectRows($table->name, $values, $target);

		foreach ($result as $entry) {
			if ($entry[$table->userGroup] == "USERA") {
				$isUserA = true;
			}
			if ($entry[$table->userGroup] == "ADMIN") {
				$isAdmin = true;
			}
		}

		$table = DataAccessConfig::pageMenuData();
		$values = array($table->all);
		$target = array("'x'" => "'y'");

		if ($isGuest === true) {
			$target = array($table->guestVis => 1);
		}
		if ($isUserA === true) {
			$target = array($table->userVis => 1);
		}
		if ($isAdmin === true) {
			$target = array($table->adminVis => 1);
		}

		$result = parent::selectRows($table->name, $values, $target);
		$pageMenuEntries = array();
		$submenus = 0;
		foreach ($result as $entry) {
			$menuEntry = new PageMenuEntry();
			$menuEntry->setId($entry[$table->id]);
			$menuEntry->setName($entry[$table->entryName]);
			$menuEntry->setUrl($entry[$table->url]);
			$menuEntry->setTitle($entry[$table->hoverText]);
			$menuEntry->setOrientation($entry[$table->orientation]);
			if ($submenus > 0) {
				$pageMenuEntries[count($pageMenuEntries) - 1]->addSubmenu($menuEntry);
				$submenus--;
			} else {
				$pageMenuEntries[] = $menuEntry;
			}
			if ($entry[$table->submenus] > 0) {
				$submenus = $entry[$table->submenus];
			}
		}

		return $pageMenuEntries;
	}

    /**
     *  Encrypts a value.
     *
     *  @param {string} value The value to encrypt.
     *  @return An encrypted version of <code>value</code>.
     */
	public static function encrypt($value) {
		return sha1($value);
	}

}
