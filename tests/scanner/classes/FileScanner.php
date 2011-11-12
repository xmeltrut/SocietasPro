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
 * @todo Colour code lines of code
 */

class FileScanner {

	/**
	 * Store the file
	 */
	protected $data;
	
	/**
	 * Store a log of messages
	 */
	private $messages = array();
	
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
