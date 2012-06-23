<?php
/**
 * Database singleton
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Database
 */

namespace Framework\Database;

use Framework\Core\Singleton;

class Database extends Singleton {

	/**
	 * Variable to hold the instance of this singleton
	 */
	private static $instance;
	
	/**
	 * Variable to hold the connection
	 */
	private static $connection;
	
	/**
	 * Singleton implementation
	 */
	public static function getInstance () {
	
		if (!isset(self::$instance)) {
		
			$className = __CLASS__;
			self::$instance = new $className;
			
			try {
				self::$connection = new PdoWrapper(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
				self::$connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				throw new GeneralException($e->getMessage());
			}
		
		}
		
		return self::$connection;
	
	}

}
