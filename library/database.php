<?php
/**
 * Database object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Database
 *
 * @todo Improve error handling of mysql_connect function
 * @todo Improve error handling of mysql_Select_db function
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
	 * Singleton
	 */
	public static function getInstance () {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
			self::$connection = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("CONNECT: " . mysql_error());
			mysql_select_db(DB_NAME, self::$connection) or die("SELECT: " . mysql_error());
		}
		return self::$instance;
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
		
		$resource = mysql_query($sql, self::$connection) or die("QUERY: " . mysql_error());
		return new Recordset($resource);
	
	}

}
