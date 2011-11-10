<?php
/**
 * Check that any classes have a unit test
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
 */

class UnitTestScanner extends FileScanner implements iScanner {

	/**
	 * Constructor
	 *
	 * @param array $file File
	 */
	function __construct ($file) {
		parent::__construct($file);
	}
	
	/**
	 * Scan for classes
	 *
	 * @return array Messages
	 */
	public function scan () {
	
		foreach ($this->data as $line => $code) {
		
			if (preg_match("/^class ([a-z]+) {/i", $code)) {
				$this->log(LEVEL_NOTICE, "Unit test missing", $line, $code);
			}
		
		}
		
		return $this->getMessages();
	
	}

}
