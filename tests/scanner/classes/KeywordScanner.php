<?php
/**
 * This scans for keywords that shouldn't appear
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
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
		
			// check for print_r that has been left in
			if (preg_match("/print_r/", $code) {
				$this->log(LEVEL_WARN, "print_r", $line);
			}
		
		}
		
		return $this->getMessages();
	
	}

}
