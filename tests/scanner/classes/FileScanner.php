<?php
/**
 * Base class for file scanners
 *
 * File scanners take one argument as the constructor - an array
 * which is a file read in from file()
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
 */

class FileScanner extends Scanner {

	/**
	 * Store the file
	 */
	protected $data;
	
	/**
	 * Constructor
	 *
	 * @param array $file File data
	 */
	function __construct ($file) {
	
		$this->data = $file;
	
	}

}
