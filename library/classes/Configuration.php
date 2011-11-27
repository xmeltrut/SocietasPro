<?php
/**
 * Access configuration variables
 *
 * Using this static class, you can gain access to any configuration variables using the
 * syntax Configuration::get("configOption");
 *
 * @author Chris Worfolk <chris@buzzsports.com>
 * @package SocietasPro
 * @subpackage Core
 */

class Configuration {

	/**
	 * Hold all the configuration options from the database
	 */
	private static $data = false;
	
	/**
	 * This is a static class, so no instancing
	 */
	private function __construct () {
	}
	
	/**
	 * Get a value from the configuration
	 *
	 * @param string $option Config option
	 * @return string Value, or false if it does not exist
	 */
	public static function get ($option) {
	
		// have we initialised the data?
		if (self::$data == false) {
			self::initialise();
		}
		
		// search for the value
		if (array_key_exists($option, self::$data)) {
			return self::$data[$option];
		} else {
			return false;
		}
	
	}
	
	/**
	 * Get the URL of the install
	 *
	 * @return string URL
	 */
	public static function getUrl () {
	
		$protocol = ($_SERVER["HTTPS") ? "https" : "http";
		$server = $_SERVER["SERVER_NAME"];
		return $protocol.":".$server;
	
	}
	
	/**
	 * Initalise the data array
	 */
	private static function initialise () {
	
		// create a database object
		$db = Database::getInstance();
		
		// query for all config options
		$sql = "SELECT * FROM ".DB_PREFIX."config ";
		$rec = $db->query($sql);
		
		// loop through results
		self::$data = array();
		
		while ($row = $rec->fetch()) {
			self::$data[$row["configOption"]] = $row["configValue"];
		}
	
	}
	
	/**
	 * Reload the configuration
	 */
	public static function reload () {
	
		self::initialise();
	
	}

}
