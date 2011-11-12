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
		
		}
		
		return $this->getMessages();
	
	}

}
