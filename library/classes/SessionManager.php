<?php
/**
 * The session manager manages all access to $_SESSION. This way
 * we can isolate the functions for testing, or if we want to
 * store session information in a different manner.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

class SessionManager extends Singleton {

	private static $instance;
	
	/**
	 * Whether or not to use persistent data
	 */
	private static $persistent;
	
	/**
	 * If we are not using persistent data, we will store the session
	 * data in here
	 */
	private $data;
	
	/**
	 * Get a session variable
	 *
	 * @param string $key Session variable key
	 * @return mixed Value
	 */
	public function get ($key) {
	
		if (self::$persistent) {
			if (isset($_SESSION[$key])) {
				return $_SESSION[$key];
			} else {
				return false;
			}
		} else {
			if (isset($this->data[$key])) {
				return $this->data[$key];
			} else {
				return false;
			}

		}
	
	}
	
	/**
	 * Singleton
	 *
	 * @param boolean $persistent Use persistence or not
	 */
	public static function getInstance ($persistent = true) {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
			
			if ($persistent) {
				self::$persistent = true;
				session_start();
			} else {
				self::$persistent = false;
			}
		}
		return self::$instance;
	}
	
	/**
	 * Set a session variable
	 *
	 * @param string $key Variable key
	 * @param mixed $value Value
	 * @return boolean Success
	 */
	public function set ($key, $value) {
	
		if (self::$persistent) {
			$_SESSION[$key] = $value;
		} else {
			$this->data[$key] = $value;
		}
		
		return true;
	
	}

}
