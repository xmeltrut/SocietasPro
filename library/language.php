<?php
/**
 * Language module, adds multi-lingual support.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

class Language {

	/**
	 * Variable to hold instance
	 */
	private static $instance;
	
	/**
	 * Variable to hold the language strings
	 */
	private static $strings = array();
	
	/**
	 * If all else fails, we default to English
	 */
	const DEFAULT_LANGUAGE = "en";
	
	/**
	 * Prevent instancing
	 */
	private function __construct () {
	}
	
	/**
	 * Singleton
	 */
	public static function getInstance () {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
			self::load(Configuration::get("language"));
		}
		return self::$instance;
	}
	
	/**
	 * Get an array of language strings
	 *
	 * @return array Language strings
	 */
	public function getStrings () {
		return self::$strings;
	}
	
	/**
	 * Return an array of languages available
	 *
	 * @return array Associative array
	 */
	public function listAsArray () {
	
		$languageDir = "../library/languages/";
		$arr = array();
		
		$handle = opendir($languageDir);
		while (false !== ($file = readdir($handle))) {
			preg_match("/^([a-z]{2})\.php$/", $file, $matches);
			if (count($matches) > 0) {
				$filename = $matches[0];
				$filedata = file($languageDir.$filename);
				$language = trim(substr($filedata[2], 3));
				$arr[$matches[1]] = $language;
			}
	    }
	    
	    return $arr;
	
	}
	
	/**
	 * Load a set of language strings
	 *
	 * @param string $languageCode Two character ISO code
	 */
	private static function load ($languageCode) {
	
		$languageFile = "languages/" . $languageCode . ".php";
		
		if (!fileExists($languageFile)) {
			return self::load(self::DEFAULT_LANGUAGE);
		}
		
		include_once($languageFile);
		self::$strings = $language_strings;
		
		// load strings in as constants
		foreach ($language_strings as $key => $val) {
			define("LANG_".strtoupper($key), $val);
		}
	
	}

}