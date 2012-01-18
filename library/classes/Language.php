<?php
/**
 * Language module, adds multi-lingual support.
 *
 * The language strings are used in three places. Firstly, every one gets
 * converted into a constant named LANG_STRING. Secondly, they are used
 * in Smarty as {$lang_string}. Finally they are also used in certain database
 * tables (currently just audit_actions) as Localised columns.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

class Language extends Singleton {

	/**
	 * Variable to hold instance
	 */
	private static $instance;
	
	/**
	 * Variable to hold the language strings and content (longer strings)
	 */
	private static $strings = array();
	private static $content = array();
	
	/**
	 * If all else fails, we default to English
	 */
	const DEFAULT_LANGUAGE = "en";
	
	/**
	 * Get a content string. We use content strings because we don't want to be
	 * setting up huge constants for content which will only be used on one page.
	 *
	 * @param string $key Key
	 * @return string Content, or false if not found
	 */
	public static function getContent ($key) {
	
		if (array_key_exists($key, self::$content)) {
			return self::$content[$key];
		} else {
			return false;
		}
	
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
	
		$languageDir = ROOT_DIR."../library/languages/";
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
	
		// build the file location
		$languageFile = "languages/" . $languageCode . ".php";
		
		// check if file exists
		if (!fileExists($languageFile)) {
			return self::load(self::DEFAULT_LANGUAGE);
		}
		
		// load default language
		require("languages/".self::DEFAULT_LANGUAGE.".php");
		$strings = $language_strings;
		$content = $language_content;
		
		// load custom language
		if ($languageCode != self::DEFAULT_LANGUAGE) {
		
			// check file exists
			if (!fileExists($languageFile)) {
				return self::load(self::DEFAULT_LANGUAGE);
			}
			
			// load file
			require($languageFile);
			
			// overwrite default language
			$strings = array_merge($strings, $language_strings);
			$content = array_merge($content, $language_content);
		
		}
		
		// set instance varaibles
		self::$strings = $strings;
		self::$content = $content;
		
		// load strings in as constants
		foreach ($strings as $key => $val) {
			define("LANG_".strtoupper($key), $val);
		}
	
	}

}