<?php
/**
 * Check the system for minimum requirements
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 *
 * @todo There is a better way we can do this
 */

class SystemTest {

	const INSTALLED = "INSTALLED";
	const MISSING = "MISSING";
	const OK = "OK";
	const WARNING = "WARNING";
	
	/**
	 * Check cURL is installed
	 *
	 * @return boolean
	 */
	public function checkCurl () {
		return function_exists("curl_init");
	}
	
	/**
	 * Check if magic quotes are disabled
	 *
	 * @return boolean
	 */
	public function checkMagicQuotes () {
		return (get_magic_quotes_gpc()) ? false : true;
	}
	
	/**
	 * Check the PHP version is recent enough
	 *
	 * @return boolean
	 */
	public function checkPhpVersion () {
		$version = floatval($this->getPhpVersion());
		return ($version >= 5.3) ? true : false;
	}
	
	/**
	 * Get cURL information
	 *
	 * @return string Status
	 */
	public function getCurl () {
		if ($this->checkCurl()) {
			return self::INSTALLED;
		} else {
			return self::MISSING;
		}
	}
	
	/**
	 * Get information on magic quotes
	 */
	public function getMagicQuotes () {
		if (get_magic_quotes_gpc()) {
			return self::WARNING;
		} else {
			return self::OK;
		}
	}

	/**
	 * Get PHP version
	 *
	 * @return string PHP version
	 */
	public function getPhpVersion () {
		return phpversion();
	}

}
