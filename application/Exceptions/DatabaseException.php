<?php
/**
 * Handles database errors.
 *
 * @author Chris Worfolk <chris@buzzsports.com>
 * @package SocietasPro
 * @subpackage Exceptions
 */

namespace Exceptions;

use Framework\Database\Database;
use Framework\Logging\ErrorLogger;

class DatabaseException extends \Exception {

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
			ErrorLogger::log($db->getErrorNumber(), $db->getError(), $sql);
		
		}
		
		// output
		if (MODE == "DEBUG") {
		
			$msg = "FATAL DATABASE ERROR<br />
					SQL: " . $sql . "<br />
					Message: " . $db->getError() . "<br />
					Code: " . $db->getErrorNumber() . "<br /><br />";
			print $msg;
			debug_print_backtrace();
			exit(1);
		
		} else {
		
			throw new HttpErrorException(500, false);
		
		}
	
	}

}
