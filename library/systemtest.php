<?php
/**
 * Check the system for minimum requirements
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 */

class SystemTest {

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
	 * Get PHP version
	 *
	 * @return string PHP version
	 */
	public function getPhpVersion () {
		return phpversion();
	}

}
