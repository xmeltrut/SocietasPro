<?php
/**
 * Doctrine bootstrapper
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Database
 */

namespace Framework\Database;

use Framework\Core\Singleton;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;

class EntityManager extends Singleton {

	private static $instance;
	private static $em;
	
	/**
	 * Singleton implementation
	 */
	public static function getInstance () {
	
		if (!isset(self::$instance)) {
		
			$className = __CLASS__;
			self::$instance = new $className;
			self::setup();
		
		}
		
		return self::$em;
	
	}
	
	/**
	 * Setup the database connection
	 */
	public static function setup () {
	
		$paths = array("./application/Entities");
		$isDevMode = true;
		$dbParams = array(
			"driver"   => "pdo_".DB_TYPE,
			"host"     => DB_HOST,
			"user"     => DB_USER,
			"password" => DB_PASS,
			"dbname"   => DB_NAME
		);
		
		$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
		self::$em = DoctrineEntityManager::create($dbParams, $config);
	
	}

}
