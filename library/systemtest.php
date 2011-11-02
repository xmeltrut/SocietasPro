<?php
/**
 * Check the system for minimum requirements
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 */

class SystemTest {

	const INSTALLED = "INSTALLED";
	const MISSING = "MISSING";
	
	/**
	 * Check cURL is installed
	 *
	 * @return boolean
	 */
	public function checkCurl () {
		return function_exists("curl_init");
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
	 * Get PHP version
	 *
	 * @return string PHP version
	 */
	public function getPhpVersion () {
		return phpversion();
	}

}
