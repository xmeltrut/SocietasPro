<?php
/**
 * Checks that code has been formatted correctly
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
 *
 * @todo Scan for if, foreach, for, etc without correct spacing
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
			
			// use real tabs
			if (strpos($code, "    ")) {
				$this->log(LEVEL_NOTICE, "Using spaces instead of tabs", $line, $code);
			}
			
			// blank spaces at the end of a line
			if (substr($code, -1) == " ") {
				$this->log(LEVEL_NOTICE, "Blank space at the end of the line", $line, $code);
			}
			
			// not formatting function definitions correctly
			if (strpos($code, "){") !== false) {
				$this->log(LEVEL_NOTICE, "Use a space between arguments and brackets, ) {", $line, $code);
			}
			
			if (preg_match("/(function|class) ([a-z0-9_\-]+)(\(|{)/i", $code)) {
				$this->log(LEVEL_NOTICE, "Use a space between name and brackets", $line, $code);
			}
		
		}
		
		return $this->getMessages();
	
	}

}
