<?php
/**
 * General function library
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
 */

/**
 * Autoload a missing class
 *
 * @param string $className Class name
 */
function __autoload ($className) {

	$filePath = "classes/".$className.".php";
	
	if (file_exists($filePath)) {
		require($filePath);
	} else {
		throw new Exception("Class " . $className . " missing.");
	}

}

/**
 * This is a custom sorting function used in DirectoryCursor, but we can't
 * do it inline because it will attempt to redeclare itself.
 *
 * @param int $a Line number
 * @param int $b Line number
 * @return int Movement of element
 */
function sortByLineNumber($a, $b) {
	if ($a[2] == $b[2]) { return 0; }
	return ($a[2] < $b[2]) ? -1 : 1;
}
