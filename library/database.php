<?php
/**
 * Database object.
 *
 * @todo Re-implement this as a singleton
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
	 * Singleton
	 */
	public static function getInstance () {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
			self::$connection = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("CONNECT: " . mysql_error()); // @todo Tidy this up
			mysql_select_db(DB_NAME, self::$connection) or die("SELECT: " . mysql_error()); // @todo Tidy this up
		}
		return self::$instance;
	}
	
	/**
	 * Query the database.
	 *
	 * @param string $sql SQL statement to execute
	 */
	public function query ($sql) {
	
		$resource = mysql_query($sql, self::$connection) or die("QUERY: " . mysql_error());
		return new Recordset($resource);
	
	}

}
