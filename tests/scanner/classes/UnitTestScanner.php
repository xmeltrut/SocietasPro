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
				
				$directories = array (
					"Controllers",
					"Core",
					"Library",
					"Models",
					"Objects"
				);
				
				$testExists = false;
				
				foreach ($directories as $directory) {
					if (file_exists("../phpunit/".$directory."/".$filename)) {
						$testExists = true;
					}
				}
				
				if ($testExists === false) {
					$this->log(LEVEL_NOTICE, "Unit test missing (".$filename.")", $line, $code);
				}
			
			}
		
		}
		
		return $this->getMessages();
	
	}

}
