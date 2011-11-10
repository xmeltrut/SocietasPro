<?php
/**
 * Handles directory searching
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
 */

class DirectoryCursor {

	/**
	 * Hold an array of messages
	 */
	private $messages;
	
	/**
	 * Add messages to the main message log
	 *
	 * @param string $filePath File path
	 * @param array $arr Messages
	 */
	private function addMessages ($filePath, $arr) {
	
		foreach ($arr as $element) {
			array_unshift($element, $filePath);
			$this->messages[] = $element;
		}
	
	}
	
	/**
	 * Scan a directory
	 */
	public function scan () {
	
	
	
	}
	
	/**
	 * Scan a file
	 *
	 * @param string $filePath File path
	 */
	private function scanFile ($filePath) {
	
		// get the file contents
		$file = file($filePath);
		
		// scanning
		$keywordScanner = new KeywordScanner($file);
		$this->addMessages($filePath, $keywordScanner->scan());
		
		$unitTestScanner = new UnitTestScanner($file);
		$this->addMessages($filePath, $unitTestScanner->scan());
	
	}

}
