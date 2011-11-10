<?php
/**
 * Base class for file scanners
 *
 * File scanners take one argument as the constructor - an array
 * which is a file read in from file()
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
 *
 * @todo Add validation to logs
 */

class FileScanner {

	/**
	 * Store the file
	 */
	private $data;
	
	/**
	 * Store a log of messages
	 */
	private $messages;
	
	/**
	 * Constructor
	 *
	 * @param array $file File data
	 */
	function __construct ($file) {
	
		$this->data = $file;
	
	}
	
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
	protected function log ($level, $msg, $line = 0) {
	
		$this->messages[] = array (
			$level,
			$msg,
			$line
		);
	
	}

}
