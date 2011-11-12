<?php
/**
 * Checks that code has been formatted correctly
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
 */

class FormattingScanner extends FileScanner implements iScanner {

	/**
	 * Constructor
	 *
	 * @param array $file File
	 */
	function __construct ($file) {
		parent::__construct($file);
	}
	
	/**
	 * Scan for formatting errors
	 *
	 * @return array Messages
	 */
	public function scan () {
	
		foreach ($this->data as $line => $code) {
		
			//$code = trim($code);
			$code = str_replace("\n", "", $code);
			$code = str_replace("\r", "", $code);
			
			if (strpos($code, "    ")) {
				$this->log(LEVEL_NOTICE, "Using spaces instead of tabs", $line, $code);
			}
			
			if (substr($code, -1) == " ") {
				$this->log(LEVEL_NOTICE, "Blank space at the end of the line", $line, $code);
			}
		
		}
		
		return $this->getMessages();
	
	}

}
