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
	
		$namespace = "";
		
		foreach ($this->data as $line => $code) {
		
			// find namespace definitions
			if (preg_match("/namespace ([a-z]+);/i", $code, $matches)) {
				$namespace = $matches[1];
			}
			
			// find class definitions
			if (preg_match('/^class ([a-z]+)([a-z \\\]*)\{/i', $code, $matches)) {
				$filename = $matches[1]."Test.php";
				if ($namespace != "") {
					$filename = ucfirst($namespace)."_".$filename;
				}
				$path = "../phpunit/".$filename;
				if (!file_exists($path)) {
					$this->log(LEVEL_NOTICE, "Unit test missing (".$filename.")", $line, $code);
				}
			} else {
			}
		
		}
		
		return $this->getMessages();
	
	}

}
