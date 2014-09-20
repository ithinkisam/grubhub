<?php

/**
 *  This data source class contains methods for accessing message
 *  data.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs.
 *      08/17/2014 (SDB) - Updated for db changes.
 */
class MessageDAO extends DatabaseUser {
    
    /**
     *  Retrieves the message corresponding to a give id.
     *
     *  @param {integer/string} id The message code.
     *  @return {string} The message corresponding to the provided
     *          id if it exists, "Message: <id>" otherwise.
     */
    public function getMessage($id) {
        parent::verifyTypes($id, array("integer", "string"));
        $id = intval($id);
        $table = DataAccessConfig::messageData();
        $values = array($table->messageText);
        $target = array($table->messageId => $id);
        $result = $this->selectRows($table->tableName, $values, $target);
        if (count($result) != 1) {
            return "Message ID: " . $id;
        }
        return $result[0][$table->messageText];
    }

}
