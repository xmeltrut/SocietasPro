<?php
/**
 * Scans the language files to report any missing information
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
 */

class LanguageScanner extends Scanner implements iScanner {

	/**
	 * Directory of languages, including trailing slash
	 */
	const LANG_DIR = "../../library/languages/";
	
	/**
	 * Variable to hold the filepath
	 */
	private $filePath;
	
	/**
	 * Constructor
	 *
	 * @param string $filePath File path
	 */
	function __construct ($filePath) {
		$this->filePath = $filePath;
	}
	
	/**
	 * Scan the file
	 */
	public function scan () {
	
		// check if this is a language file
		if (substr($this->filePath, 0, strlen(self::LANG_DIR)) == self::LANG_DIR) {
		
			// check it isn't the default language file
			$languageCode = substr($this->filePath, strlen(self::LANG_DIR), 2);
			
			if ($languageCode != "en") {
			
				// get the data for the default language
				require(self::LANG_DIR."en.php");
				
				$mainStrings = $language_strings;
				$mainContent = $language_content;
				
				// get the data for this language
				require($this->filePath);
				
				$thisStrings = $language_strings;
				$thisContent = $language_content;
				
				// compare them
				$keys = array_diff_key($mainStrings, $thisStrings);
				foreach ($keys as $key => $val) {
					$this->log(LEVEL_WARN, "Language string '$key' is missing", 0, $val);
				}
				
				$keys = array_diff_key($mainContent, $thisContent);
				foreach ($keys as $key => $val) {
					$this->log(LEVEL_WARN, "Language content '$key' is missing", 0, $val);
				}
				
				// and compare backwards too
				$keys = array_diff_key($thisStrings, $mainStrings);
				foreach ($keys as $key => $val) {
					$this->log(LEVEL_NOTICE, "String '$key' is not required", 0, $val);
				}
				
				$keys = array_diff_key($thisContent, $mainContent);
				foreach ($keys as $key => $val) {
					$this->log(LEVEL_NOTICE, "Content '$key' is not required", 0, $val);
				}
			
			}
		
		}
		
		return $this->getMessages();
	
	}

}