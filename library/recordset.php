<?php
/**
 * Recordset for a database query.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Database
 */

class Recordset {

	/**
	 * Variable to hold database resource.
	 */
	private $resource;
	
	/**
	 * Constructor.
	 *
	 * @param Object $resource Database resource
	 */
	function __construct ($resource) {
		$this->resource = $resource;
	}
	
	/**
	 * Fetch a result row.
	 *
	 * @return array Associative array
	 */
	public function fetch () {
		return mysql_fetch_assoc($this->resource);
	}
	
	/**
	 * Fetch as an associative array.
	 */
	public function fetchArray () {
		return mysql_fetch_array($this->resource);
	}
	
	/**
	 * Free up the memory.
	 */
	public function free () {
		mysql_free_result($this->resource);
	}
	
	/**
	 * Count the number of rows.
	 *
	 * @return int Number of rows
	 */
	public function getRows () {
		return mysql_num_rows($this->resource);
	}

}
