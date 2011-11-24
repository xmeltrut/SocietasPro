<?php
/**
 * Authorisation module.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

class Authorisation {

	private static $instance;
	
	/**
	 * Prevent people creating instances
	 */
	private function __construct () {
	}
	
	/**
	 * Encode a password
	 *
	 * @param string $password Password to encode
	 * @return string Encoded password
	 */
	public function encodePassword ($password) {
		$encodedPassword = md5(PASSWORD_SALT . $password);
		return $encodedPassword;
	}
	
	/**
	 * Get the admin style
	 *
	 * @return int AdminStyle
	 */
	public function getAdminStyle () {
		return intval($_SESSION["sp_admin_style"]);
	}
	
	/**
	 * Get the current user's ID
	 *
	 * @return int ID
	 */
	public function getID () {
		return intval($_SESSION["sp_user_id"]);
	}
	
	/**
	 * Singleton
	 */
	public static function getInstance () {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
			session_start();
		}
		return self::$instance;
	}
	
	/**
	 * Check if the user is logged in
	 *
	 * @return boolean True if logged in, otherwise false
	 */
	public function isLoggedIn () {
	
		if (isset($_SESSION["sp_logged_in"])) {
			if ($_SESSION["sp_logged_in"] == "true") {
				return true;
			}
		}
		
		return false;
	
	}
	
	/**
	 * Login
	 *
	 * @param string $email Email address
	 * @param string $password Password
	 * @param string $msg Return message
	 * @return boolean Success
	 */
	public function login ($email, $password, &$msg) {
	
		// initialise variables
		$success = false;
		
		// create a database connection
		$db = Database::getInstance();
		
		// select the user
		$sql = "SELECT * FROM ".DB_PREFIX."members
				WHERE memberEmail = '".escape($email)."'";
		$rec = $db->query($sql);
		
		if ($rec->getRows() > 0) {
		
			// check the password
			$row = $rec->fetch();
			
			if ($this->encodePassword($password) == $row["memberPassword"]) {
			
				// check they are an administrator
				if ($row["memberPrivileges"] == 2) {
			
					// successfully logged in
					$success = true;
				
				}
			
			}
		
		}
		
		// check for success
		if ($success) {
			$_SESSION["sp_logged_in"] = "true";
			$_SESSION["sp_user_id"] = $row["memberID"];
			$_SESSION["sp_admin_style"] = $row["memberAdminStyle"];
			return true;
		} else {
			$msg = "There was no match for the username and password.";
			return false;
		}
	
	}
	
	/**
	 * Log a user out
	 */
	public function logout () {
		$_SESSION["sp_logged_in"] = "false";
		session_destroy();
	}
	
	/**
	 * Set the admin style
	 *
	 * @param int $value AdminStyle
	 */
	public function setAdminStyle ($value) {
		$_SESSION["sp_admin_style"] = intval($value);
	}

}
