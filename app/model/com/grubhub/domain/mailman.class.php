<?php

/**
 *  This utility class provides methods for sending different types
 *  of email messages.
 *
 *  Change History:
 *      01/10/2014 (SDB) Implemented docs
 */
class Mailman extends ObjectBase {
    
    /* Private class data */
    private static $ADMIN = "ithinkisam@gmail.com";
    
    private static function sendEmail($to, $subject, $message) {
        if (is_array($to)) {
            foreach ($to as $recipient) {
                mail($recipient, $subject, $message);
            }
            return true;
        } else {
            return mail($to, $subject, $message);
        }
    }
    
    //////////////////////////////////////////////////////////
    ///////////////          SEPARATOR         ///////////////
	//////////////////////////////////////////////////////////
    
    public static function sendNoticeOfNewUser($user) {
        $obj = new ObjectBase();
        $obj->verifyType($user, "User");
        
        $username = $user->getUsername();
        $subject = "The Grub Hub -- New User";
		$message = "

A new user has created an account on your site! Congratulations!

Username: $username
";
		return self::sendEmail(self::$ADMIN, $subject, $message);
    }
    
    //////////////////////////////////////////////////////////
    ///////////////          SEPARATOR         ///////////////
	//////////////////////////////////////////////////////////
    
    public static function sendFeedback($user, $feedback) {
        $obj = new ObjectBase();
        $obj->verifyType($user, "User");
        $obj->verifyType($feedback, "string");
        
        $username = $user->getUsername();
        $subject = "The Grub Hub -- User Feedback";
        $message = "

The following feedback has been submitted on your site.

This email is purely informational. Please do not reply.

User: $username
Feedback:
--------------------------------
    $feedback
--------------------------------
";
		return self::sendEmail(self::$ADMIN, $subject, $message);
    }
    
    //////////////////////////////////////////////////////////
    ///////////////          SEPARATOR         ///////////////
	//////////////////////////////////////////////////////////
    
}
