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
	function __construct ($sql = "") {
	
		if (MODE == "DEBUG") {
		
			// get a database instance
			$db = Database::getInstance();
			
			$msg = "FATAL DATABASE ERROR<br />
					SQL: " . $sql . "<br />
					Message: " . $db->getError() . "<br />
					Code: " . $db->getErrorNumber();
			die($msg);
		
		} else {
		
			require("exceptions/HttpErrorException.php");
			throw new HttpErrorException(500);
		
		}
	
	}

}
