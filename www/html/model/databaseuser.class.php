<?php

/**
 *  This abstract class provides basic querying functionality
 *  for any implementing class that wishes to access a data source.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
abstract class DatabaseUser extends ObjectBase {

    /* Public class values */
    const ORDER_BY_ASC  = 1;
    const ORDER_BY_DESC = -1;
    
    /**
     *  Updates one or more rows in a database table with the
     *  provided values.
     *
     *  @param {string} table The table to target.
     *  @param {key=>value} values Key-value pairs identifying the
     *          fields you wish to update and their corresponding
     *          values.
     *  @param {key=>value} target Key-value pairs identifying the
     *          fields you wish to target and their corresponding
     *          values.
     *  @param {resource} dbhandle=false Optional database
     *          connection handle.  
     *  @return {boolean} Whether the update was successful or not.
     */
    public function updateTable($table, $values, $target, $dbhandle=false) {
        $values_size = count($values);
        $target_size = count($target);
        if ($target_size == 0 || $values_size == 0) { return false; }
        
        $values = self::encodeValues($values);
        $target = self::encodeValues($target);
        
        $query = "UPDATE $table SET";
        
        $key_values = array();
        foreach ($values as $key => $value) {
            $key_values[] = $key . "=" . $value;
        }
        
        $query .= implode(", ", $key_values);
        $query .= " WHERE";
        
        $key_values = array();
        foreach ($target as $key => $value) {
            $key_values[] = $key . "=" . $value;
        }
        
        $query .= implode(" AND ", $key_values);
        
        Logger::debug(get_class(), __FUNCTION__, $query);
        return self::sendQuery($query, $dbhandle);
    }
    
    /**
     *  Inserts a single row into a database table.
     *
     *  @param {string} table The database table to target.
     *  @param {key=>value} values Key-value pairs identifying the
     *          columns and values to insert into the table.
     *  @param {resource} dbhandle=false Optional database
     *          connection handle.
     *  @return {boolean} Whether the insert was successful or not.
     */
    public function insertRow($table, $values, $dbhandle=false) {
        $value_size = count($values);
        if ($value_size == 0) { return false; }
        
        $values = self::encodeValues($values);
        
        $query = "INSERT INTO $table (";
        $query .= implode(', ', array_keys($values));
        $query .= ") VALUES (";
        $query .= implode(', ', array_values($values));
        $query .= ")";
        
        Logger::debug(get_class(), __FUNCTION__, $query);
        return self::sendQuery($query, $dbhandle);
    }
    
    /**
     *  Selects any number of rows from a database table.
     *
     *  @param {string} table The table to target.
     *  @param {key=>value} values Key-value pairs identifying which
     *          database fields you want returned.
     *  @param {key=>value} target Key-value pairs identifying the
     *          columns and values you are targeting.
     *  @param {array(string,int)} orderby=NULL This is an array of
     *          size 2.
     *          index 0: The column to order by
     *          index 1: DatabaseUser::ORDER_BY_ASC or
     *                   DatabaseUser::ORDER_BY_DESC
     *  @param {resource} dbhandle=false Optional database
     *          connection handle.
     *  @return {array{key=>value}} Each entry of the returned array
     *          contains a single row indexed by column name. For
     *          example, if you expect your query to return a single
     *          row [$result = selectRows(...)], and you want to
     *          access the value for 'firstName', use the following
     *          syntax:
     *              $result[0]["firstName"]
     */
    public function selectRows($table, $values, $target, $orderby=NULL, $dbhandle=false) {
        $target_size = count($target);
        $values_size = count($values);
        if ($values_size == 0) { return false; }
        
        $values = self::encodeValues($values);
        $target = self::encodeValues($target);
        
        $query = "SELECT ";
        $query .= implode(', ', $values);
        $query .= " FROM $table";
        
        if ($target_size > 0) {
            $query .= " WHERE ";
            $key_values = array();
            foreach ($target as $key => $value) {
                $key_values[] = $key . "=" . $value;
            }
            $query .= implode(" AND ", $key_values);
        }
        
        if (!is_null($orderby) && is_array($orderby) && count($orderby) == 2) {
            $query .= " ORDER BY " . $orderby[0];
            if ($orderby[1] == self::ORDER_BY_ASC) {
                $query .= " ASC";
            }
            if ($orderby[1] == self::ORDER_BY_DESC) {
                $query .= " DESC";
            }
        }
        
        Logger::debug(get_class(), __FUNCTION__, $query);
        return self::sendQuery($query, $dbhandle);
    }
    
    /**
     *  Removes zero or more rows from the specified database table.
     *
     *  @param {string} table The database table to target.
     *  @param {key=>value} target Key-value pairs indicating the
     *          columns and values you wish to remove.
     *  @param {resource} dbhandle=false Optional database
     *          connection handle.
     *  @return {boolean} Whether the delete was successful or not.
     *          true does not necessarily mean any rows were deleted,
     *          only that the query was executed successfully.
     */
    public function deleteRows($table, $target, $dbhandle=false) {
        $target_size = count($target);
        if ($target_size == 0) { return false; }
        
        $target = self::encodeValues($target);
        
        $query = "DELETE FROM $table WHERE ";
        
        $key_values = array();
        foreach ($target as $key => $value) {
            $key_values[] = $key . "=" . $value;
        }
        $query .= implode(" AND ", $key_values);
        
        Logger::debug(get_class(), __FUNCTION__, $query);
        return self::sendQuery($query, $dbhandle);
    }
    
    /**
     *  Executes a stored procedure that returns a single value
     *  (eg. true or false, a single integer, etc).
     *
     *  @param {string} name The name of the stored procedure.
     *  @param {array:string} parameters The parameters to pass to
     *          the stored procedure.
     *  @param {resource} dbhandle=false Optional database
     *          connection handle.
     *  @return The results of the stored procedure.
     */
    public function singleValuedStoredProcedure($name, $parameters, $dbhandle=false) {
        $parameters = self::encodeValues($parameters);
        $query = "CALL $name(" . implode(", ", $parameters) . ")";
        Logger::debug(get_class(), __FUNCTION__, $query);
        return self::sendQuery($query, $dbhandle);
    }
    
    /**
     *  Executes the provided query and packages the results in an
     *  array for consistency.
     *
     *  @param {string} query The query string to execute.
     *  @param {resource} connection=false Optional database
     *          connection handle.
     *  @return The results of the query stored in an array, one
     *          entry for each record returned.
     */
    public function sendQuery($query, $connection=false) {
        if ($connection === false) {
            $dbhandle = self::openConnection();
        } else {
            $dbhandle = $connection;
        }
        
        if ($dbhandle !== false) {
            $result = $dbhandle->query($query);
            if ($connection === false) {
				self::closeConnection($dbhandle);
            }
            return self::packageInArray($result);
        } else {
            return false;
        }
    }
    
    /**
     *  Opens a connection to the butlergrubhub database.
     *
     *  @return {resource} A database connection handle or false
     *          if the database connection could not be established.
     */
    public function openConnection() {
        $username = "butlergrubhub";
        $password = "openUP1!";
        $database = "butlergrubhub";
        $server = "butlergrubhub.db.9643873.hostedresource.com";
        
        $dbhandle = new mysqli($server, $username, $password, $database);
        $dbfound = !mysqli_connect_errno();
        
        if ($dbfound) {
            return $dbhandle;
        } else {
            return false;
        }
    }

	/**
	 *  Begins a new transaction.
     *
     *  @return {resource} A new database connection handle for
     *          an atomic transaction.
	 */
	public function startTransaction() {
		$dbhandle = self::openConnection();
		self::sendQuery("START TRANSACTION", $dbhandle);
		return $dbhandle;
	}

	/**
     *  Commits any executed queries during this transaction. This
     *  is only useful if used in conjunction with startTransaction.
	 */
	public function commit($dbhandle) {
		self::sendQuery("COMMIT", $dbhandle);
		self::closeConnection($dbhandle);
	}

	/**
	 *  Retracts any changes made to the database during this
     *  transaction. This is only useful if used in conjunction
     *  with startTransaction.
	 */
	public function rollback($dbhandle) {
		self::sendQuery("ROLLBACK", $dbhandle);
		self::closeConnection($dbhandle);
	}
    
    /**
     *  Closes a database connection.
     *
     *  @param {resource} dbhandle The database connection handle
     *          to close.
     */
    public function closeConnection($dbhandle) {
        $dbhandle->close();
    }
    
    /**
     *  Encodes values as a method of sanitizing input and managing
     *  special characters.
     *
     *  @param {key=>value} values Key-value pairs to encode.
     *  @return {key=>value} <code>values</code> with any special
     *          characters encoded.
     */
    public function encodeValues($values) {
        foreach ($values as $key => $value) {
            if (substr($value, 0, 1) == "'" || substr($value, strlen($value) - 1, 1) == "\"") {
                $innerValue = substr($value, 1, strlen($value) - 2);
                $values[$key] = "'" . htmlentities($innerValue, ENT_QUOTES) . "'";
            } else {
                $values[$key] = htmlentities($value, ENT_QUOTES);
            }
        }
        return $values;
    }
    
    /**
     *  Reverses any encoding performed by encodeValues.
     *
     *  @param {key=>value} values Key-value pairs to decode.
     *  @return {key=>value} <code>values</code> with any special
     *          character decoded.
     */
    public function decodeValues($values) {
        foreach ($values as $key => $value) {
            $values[$key] = html_entity_decode($value, ENT_QUOTES);
        }
        return $values;
    }
    
    /*
     *  Packages the results of a query into an array for eacy and
     *  consistent access.
     *  
     *  If the returned value is either true or
     *  false, the value will be returned as is.
     *
     *  If the results come in record set form, each record will be
     *  decoded and assigned its own index in the array.
     *
     *  @param {resource} A result resource obtained from a mysql query.
     */
    private function packageInArray($result) {
        $package = array();
        if ($result === false) { return false; }
        if ($result === true) { return true; }
        while ($entry = $result->fetch_assoc()) {
            $package[] = self::decodeValues($entry);
        }
        return $package;
    }

}
