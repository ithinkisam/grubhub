<?php

/**
 *  This utility class provides logging functionality for the
 *  application. It provides 4 basic types of logging:
 *      
 *      1) DEBUG
 *      2) INFO
 *      3) WARN
 *      4) ERROR
 *
 *  Different logging levels can be used based on the severity of
 *  the message being logged. Each of the 4 log levels can be
 *  configured separately from one another.
 *
 *  Change History:
 *      01/10/2014 (SDB) Implemented docs
 */
class Logger {

	const debug = false;
	const info  = true;
    const warn  = true;
    const error = true;

    const log     = false;
	const console = true;

	const log_loc = '/home/content/73/9643873/html/sam/dev/grubhubv2/logs/log.log';

    public static function debug($class, $function, $entry) {
        if (self::debug) {
			self::toConsole("DEBUG", $class . "::" . $function . "::" . $entry);
            self::toLog("DEBUG", $class . "::" . $function . "::" . $entry);
		}
    }

    public static function info($class, $function, $entry) {
        if (self::info) {
			self::toConsole("INFO", $class . "::" . $function . "::" . $entry);
            self::toLog("INFO", $class . "::" . $function . "::" . $entry);
		}
    }
    
    public static function warn($class, $function, $entry) {
        if (self::warn) {
			self::toConsole("WARN", $class . "::" . $function . "::" . $entry);
            self::toLog("WARN", $class . "::" . $function . "::" . $entry);
		}
    }
    
    public static function error($class, $function, $entry) {
        if (self::error) {
			self::toConsole("ERROR", $class . "::" . $function . "::" . $entry);
            self::toLog("ERROR", $class . "::" . $function . "::" . $entry);
		}
    }

	private static function toLog($level, $message) {
		// TC todo
	}

	private static function toConsole($level, $message) {
		echo $level . " -- " . $message . "<br/>";
	}

}
