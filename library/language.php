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
			self::load("kr");
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