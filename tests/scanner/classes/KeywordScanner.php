<?php
/**
 * This scans for keywords that shouldn't appear
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
 *
 * Add scanning for function ($vars) { formatting / braces
 */

class KeywordScanner extends FileScanner implements iScanner {

	/**
	 * Constructor
	 *
	 * @param array $file File
	 */
	function __construct ($file) {
		parent::__construct($file);
	}
	
	/**
	 * Scan for keywords
	 *
	 * @return array Messages
	 */
	public function scan () {
	
		foreach ($this->data as $line => $code) {
		
			if (strpos("print_r", $code) !== false) {
				$this->log(LEVEL_WARN, "print_r", $line, $code);
			}
			
			if (strpos("function construct", $code) !== false) {
				$this->log(LEVEL_WARN, "construct should be named __construct", $line, $code);
			}
			
			if (strpos("include(", $code) !== false) {
				$this->log(LEVEL_WARN, "Use require() instead of include()", $line, $code);
			}
			
			if (strpos("include_once(", $code) !== false) {
				$this->log(LEVEL_WARN, "Use require_once() instead of include_once()", $line, $code);
			}
			
			if (strpos("die(", $code) !== false) {
				$this->log(LEVEL_WARN, "Throw an exception rather than using die()", $line, $code);
			}
		
		}
		
		return $this->getMessages();
	
	}

}
