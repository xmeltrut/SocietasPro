<?php
/**
 * Error logger
 *
 * @author Chris Worfolk <chris@societaspro.org>
 */

namespace Framework\Logging;

use Model;

class ErrorLogger {

	/**
	 * Log an error into the error log
	 *
	 * @param int $code Error code
	 * @param string $details Error details
	 * @param string $sql SQL statement
	 * @return boolean Success
	 */
	public static function log ($code, $details = "", $sql = "") {
	
		$errorLogsModel = new Model\ErrorLogsModel();
		return $errorLogsModel->insert($code, $details, $sql);
	
	}

}