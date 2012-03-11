<?php
/**
 * The session manager manages all access to $_SESSION. This way
 * we can isolate the functions for testing, or if we want to
 * store session information in a different manner.
 *
 * It is implemented in a "singleton-like" pattern, where you can
 * only have one instance, but that is created automatically
 * when you call one of it's functions.
 *
 * This needs refactoring into a proper singleton, so we can allow
 * people ot instance it without actually using session cookies.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

class SessionManager extends Singleton {

	private static $instance;
	
	/**
	 * Get a session variable
	 *
	 * @param string $key Session variable key
	 * @return mixed Value
	 */
	public static function get ($key) {
	
		self::getInstance();
		
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		} else {
			return false;
		}
	
	}
	
	/**
	 * Singleton
	 *
	 * @return boolean Success
	 */
	private static function getInstance () {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
			session_start();
		}
		return true;
	}
	
	/**
	 * Set a session variable
	 *
	 * @param string $key Variable key
	 * @param mixed $value Value
	 * @return boolean Success
	 */
	public static function set ($key, $value) {
	
		self::getInstance();
		
		$_SESSION[$key] = $value;
		return true;
	
	}

}
