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
		
			if (preg_match("/^(abstract |)class ([a-z]+)([a-z ]*)\{/i", $code, $matches)) {
				$path = "../phpunit/".$matches[2]."Test.php";
				if (!file_exists($path)) {
					$this->log(LEVEL_NOTICE, "Unit test missing", $line, $code);
				}
			} else {
			}
		
		}
		
		return $this->getMessages();
	
	}

}
