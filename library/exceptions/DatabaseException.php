<?php
/**
 * Handles database errors.
 *
 * @author Chris Worfolk <chris@buzzsports.com>
 * @package SocietasPro
 * @subpackage Exceptions
 */

class DatabaseException extends Exception {

	/**
	 * Constructor
	 *
	 * @param string $sql SQL statement
	 */
	function __construct ($sql = false) {
	
		// get a database instance
			$db = Database::getInstance();
		
		if ($sql) {
		
			// log the error here
			logError($db->getErrorNumber(), $db->getError(), $sql);
		
		}
		
		// output
		if (MODE == "DEBUG") {
		
			$msg = "FATAL DATABASE ERROR<br />
					SQL: " . $sql . "<br />
					Message: " . $db->getError() . "<br />
					Code: " . $db->getErrorNumber();
			print $msg;
			exit(1);
		
		} else {
		
			throw new HttpErrorException(500, false);
		
		}
	
	}

}
