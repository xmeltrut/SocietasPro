<?php
/**
 * Database object
 *
 * If an error occurs, we throw a DatabaseException. We need to include this file,
 * but we don't need to use include_once because it's a one way trip so it won't
 * have been included before.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Database
 */

require_once("recordset.php");

function escape ($sql) {
	return mysql_real_escape_string($sql);
}

class Database {

	/**
	 * Variable to hold the instance of this singleton
	 */
	private static $instance;
	
	/**
	 * Variable to hold the connection.
	 */
	private static $connection;
	
	/**
	 * Prevent instancing
	 */
	private function __construct () {
	}
	
	/**
	 * Get the last error message
	 *
	 * @return string Error message
	 */
	public function getError () {
		return mysql_error();
	}
	
	/**
	 * Get the last error code
	 *
	 * @return int Error code
	 */
	public function getErrorNumber () {
		return mysql_errno();
	}
	
	/**
	 * Singleton
	 */
	public static function getInstance () {
	
		if (!isset(self::$instance)) {
		
			$className = __CLASS__;
			self::$instance = new $className;
			
			if (!self::$connection = mysql_connect(DB_HOST, DB_USER, DB_PASS)) {
				include("exceptions/DatabaseException.php");
				throw new DatabaseException();
			}
			
			if (!mysql_select_db(DB_NAME, self::$connection)) {
				include("exceptions/DatabaseException.php");
				throw new DatabaseException();
			}
		
		}
		
		return self::$instance;
	
	}
	
	/**
	 * Fetch one single value from the database.
	 *
	 * @param string $sql SQL statement
	 * @return mixed Value
	 */
	public function fetchOne ($sql) {
	
		$recordset = $this->query($sql);
		$row = $recordset->fetchArray();
		return $row[0];
	
	}
	
	/**
	 * Retieve the last auto increment generated ID
	 *
	 * @return int ID
	 */
	public function insertId () {
	
		return mysql_insert_id();
	
	}
	
	/**
	 * Query the database.
	 *
	 * @param string $sql SQL statement to execute
	 */
	public function query ($sql) {
	
		// validate we have been passed SQL
		if ($sql == "") {
			return false;
		}
		
		// run the query
		if (!$resource = mysql_query($sql, self::$connection)) {
			include("exceptions/DatabaseException.php");
			throw new DatabaseException($sql);
		}
		
		// return the recordset
		return new Recordset($resource);
	
	}

}
