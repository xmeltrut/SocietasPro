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
	private $messages = array();
	
	/**
	 * We need to fold indexes of files so we can loop through them
	 */
	private $directoriesToScan = array();
	private $filesToScan = array();
	
	/**
	 * Add messages to the main message log
	 *
	 * @param string $filePath File path
	 * @param array $arr Messages
	 */
	private function addMessages ($filePath, $arr) {
	
		// sort array by line number
		uasort($arr, "sortByLineNumber");
		
		// add this to the report
		$this->messages[] = array (
			$filePath,
			$arr
		);
	
	}
	
	/**
	 * Get next directory to scan
	 *
	 * @return string Directory path
	 */
	public function getNextDirectory () {
	
		return array_shift($this->directoriesToScan);
	
	}
	
	/**
	 * Entry point for scanning
	 */
	public function scan () {
	
		// add top level directories
		$this->directoriesToScan = array (
			"../../application",
			"../../library"
		);
		
		// excluded directories
		$excludedDirectories = array (
			"../../library/smarty"
		);
		
		// scan all directories
		while ($dir = $this->getNextDirectory()) {
			if (!in_array($dir, $excludedDirectories)) {
				$this->scanDirectory($dir);
			}
		}
		
		// now scan all the files
		foreach ($this->filesToScan as $file) {
			$this->scanFile($file);
		}
		
		return $this->messages;
	
	}
	
	/**
	 * Scan a directory
	 *
	 * @param $dir Directory path
	 */
	public function scanDirectory ($dir = false) {
	
		// loop through files
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if (($file != ".") && ($file != "..")) {
					$path = $dir."/".$file;
					if (is_dir($path)) {
						$this->directoriesToScan[] = $path;
					} elseif (is_file($path)) {
						$extension = substr($path, -4);
						if ($extension == ".php") {
							$this->filesToScan[] = $path;
						}
					}
				}
			}
		}
		closedir($handle);
	
	}
	
	/**
	 * Scan a file
	 *
	 * @param string $filePath File path
	 */
	private function scanFile ($filePath) {
	
		// get the file contents
		$file = file($filePath);
		
		// build scanners
		$keywordScanner = new KeywordScanner($file);
		$formattingScanner = new FormattingScanner($file);
		$unitTestScanner = new UnitTestScanner($file);
		
		// run the scan
		$scanResults = array_merge (
			$keywordScanner->scan(),
			$formattingScanner->scan(),
			$unitTestScanner->scan()
		);
		
		// log the results
		$this->addMessages($filePath, $scanResults);
	
	}

}
