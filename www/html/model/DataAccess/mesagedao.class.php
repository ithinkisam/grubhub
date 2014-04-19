<?php

/**
 *  This data source class contains methods for accessing message
 *  data.
 *
 *  Change History:
 *      01/10/2014 (SDB) - Implemented docs
 */
class MessageDAO extends DatabaseUser {
    
    /**
     *  Retrieves the message corresponding to a give code.
     *
     *  @param {integer/string} code The message code.
     *  @return {string} The message corresponding to the provided
     *          code if it exists, "Message: <code>" otherwise.
     */
    public function getMessage($code) {
        parent::verifyTypes($code, array("integer", "string"));
        $code = intval($code);
        $table = DataAccessConfig::messageData();
        $values = array($table->message);
        $target = array($table->code => $code);
        $result = $this->selectRows($table->name, $values, $target);
        if (count($result) != 1) {
            return "Message: " . $code;
        }
        return $result[0][$table->message];
    }

}
