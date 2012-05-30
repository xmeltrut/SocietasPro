<?php
/**
 * General functions library
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Installer
 */

/**
 * Parse and SQL file and return a list of queries to run.
 *
 * @param string $fileName File name
 * @return array SQL queries
 */
function parseSqlFile ($fileName) {

	// check file exists
	if (!file_exists($fileName)) {
		return false;
	}
	
	// get file
	$data = file($fileName);
	
	// initialise a return array
	$arr = array();
	
	// strip out comment lines
	foreach ($data as $line) {
		$line = trim($line);
		if ( ($line != "") && (substr($line, 0, 2) != "--") && (substr($line, 0, 1) != "#") ) {
			$arr[] = $line;
		}
	}
	
	// glue array back together
	$str = implode("\n", $arr);
	
	// swap out database prefix
	$str = str_replace("`tbl_", "`".DB_PREFIX, $str);
	
	// return array
	return explode(";", $str);

}
