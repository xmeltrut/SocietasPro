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
