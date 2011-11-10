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
	
		// add first directory
		$this->directoriesToScan[] = "../../application";
		
		// scan all directories
		while ($dir = $this->getNextDirectory()) {
			$this->scanDirectory($dir);
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
		
		// scanning
		$keywordScanner = new KeywordScanner($file);
		$this->addMessages($filePath, $keywordScanner->scan());
		
		$unitTestScanner = new UnitTestScanner($file);
		$this->addMessages($filePath, $unitTestScanner->scan());
	
	}

}
