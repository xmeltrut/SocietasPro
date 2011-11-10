<?php
/**
 * Handles database errors.
 *
 * @author Chris Worfolk <chris@buzzsports.com>
 * @package SocietasPro
 * @subpackage Exceptions
 */

class TemplateException extends Exception {

	/**
	 * Constructor
	 *
	 * @param string $sql SQL statement
	 */
	function __construct () {
	
		// build details string
		$str  = "File: " . $this->getFile() . "\n";
		$str .= "Line: " . $this->getLine() . "\n";
		$str .= "Message: " . $this->getMessage() . "\n";
		$str .= "Trace: " . $this->getTraceAsString();
		
		// log gerror message
		logError($this->getCode(), $str);
		
		// output
		if (MODE == "DEBUG") {
		
			echo(nl2br($str));
			exit(1);
		
		} else {
		
			require("exceptions/HttpErrorException.php");
			throw new HttpErrorException(500, false);
		
		}
	
	}

}
