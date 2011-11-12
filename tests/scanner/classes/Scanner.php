<?php
/**
 * Base class for scanners
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
 */

class Scanner {

	/**
	 * Store a log of messages
	 */
	private $messages = array();
	
	/**
	 * Get messages
	 *
	 * @return array Messages
	 */
	protected function getMessages () {
	
		return $this->messages;
	
	}
	
	/**
	 * Log a message
	 *
	 * @param int $level Level
	 * @param string $msg Message
	 * @param int $line Line number
	 */
	protected function log ($level, $msg, $line = 0, $code = "") {
	
		// get level information
		global $levelInfo;
		$levelName = $levelInfo[$level];
		
		// log message
		$this->messages[] = array (
			$level,
			$msg,
			$line,
			$code,
			$levelName
		);
	
	}

}
