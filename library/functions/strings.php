<?php
/**
 * String functions
 *
 * For consistently, functions in this file should start with "str"
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

/**
 * Convert a string to lower case, then capitalise the first letter
 *
 * @param string $str String to convert
 * @return string
 */
function strFirst ($str) {
	$str = strtolower($str);
	$str = ucfirst($str);
	return $str;
}

/**
 * Increment a string, used for generating unique slugs
 *
 * @param string $str String
 * @return string Incremented string
 */
function strIncrement ($str) {

	if (strpos($str, "-") === false) {
	
		$newStr = $str."-2";
	
	} else {
	
		$parts = explode("-", $str);
		$endSection = array_pop($parts);
		$newStr = implode("-", $parts)."-";
		if (is_numeric($endSection)) {
			$endNumber = (intval($endSection)+1);
			$newStr .= $endNumber;
		} else {
			$newStr .= $endSection."-2";
		}
	
	}
	
	return $newStr;

}

/**
 * Generate a random string, good for passwords
 *
 * @param int $length Length in characters
 * @return string
 */
function strRandom ($length = 8) {

	$password = "";
	$possible = "2346789abcdefghijkmnpqrtuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ";
	$maxlength = strlen($possible);
	
	for ($i = 0; $i < $length; $i++) {
		$char = substr($possible, mt_rand(0, $maxlength-1), 1);
	}
	
	return $password;

}

/**
 * Get rid of any nasty characters from a filename.
 *
 * Note, this won't actually "fix" the filename if you will, it will just
 * replace the nasty characters with underscores, which we don't really
 * use in the application, so it will still throw an invalid file not found
 * when you try to use it (as we want it to do).
 *
 * @param string $str Filename
 * @return string Cleaned filename
 */
function strSantiseFilename ($str) {

	return preg_replace("/([^a-z0-9,\.-])/i", "_", $str);

}
