<?php
/**
 * Handles database errors.
 *
 * @author Chris Worfolk <chris@buzzsports.com>
 * @package SocietasPro
 * @subpackage Exceptions
 *
 * @todo Obviously we shouldn't be showing site users the SQL errors
 */

class DatabaseException extends Exception {

	/**
	 * Constructor
	 *
	 * @param string $sql SQL statement
	 */
	function __construct ($sql = "") {
	
		// get a database instance
		$db = Database::getInstance();
		
		$msg = "FATAL DATABASE ERROR<br />
				SQL: " . $sql . "<br />
				Message: " . $db->getError() . "<br />
				Code: " . $db->getErrorNumber();
		die($msg);
	
	}

}
