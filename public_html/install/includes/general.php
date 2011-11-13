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
	$data = file_get_contents($fileName);
	
	// return array
	return explode(";", $data);

}
