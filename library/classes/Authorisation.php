<?php
/**
 * Authorisation module.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

class Authorisation extends Singleton {

	private static $instance;
	
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
		if (SessionManager::get("sp_admin_style")) {
			return intval(SessionManager::get("sp_admin_style"));
		} else {
			return 0;
		}
	}
	
	/**
	 * Get the current user's ID
	 *
	 * @return int ID
	 */
	public function getID () {
		if (SessionManager::get("sp_user_id")) {
			return intval(SessionManager::get("sp_user_id"));
		} else {
			return 0;
		}
	}
	
	/**
	 * Singleton
	 */
	public static function getInstance () {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
		}
		return self::$instance;
	}
	
	/**
	 * Check if the user is logged in
	 *
	 * @return boolean True if logged in, otherwise false
	 */
	public function isLoggedIn () {
	
		if (SessionManager::get("sp_logged_in")) {
			if (SessionManager::get("sp_logged_in") == "true") {
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
				WHERE memberEmail = ? ";
		$rec = $db->prepare($sql);
		$rec->execute(array($email));
		
		if ($rec->rowCount() > 0) {
		
			// check the password
			$row = $rec->fetch();
			
			if ($this->encodePassword($password) == $row["memberPassword"]) {
			
				// check they are a manager or admin
				if ($row["memberPrivileges"] >= 2) {
			
					// successfully logged in
					$success = true;
				
				}
			
			}
		
		}
		
		// check for success
		if ($success) {
			SessionManager::set("sp_logged_in", "true");
			SessionManager::set("sp_user_id", $row["memberID"]);
			SessionManager::set("sp_admin_style", $row["memberAdminStyle"]);
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
		SessionManager::set("sp_logged_in", "false");
		session_destroy();
	}
	
	/**
	 * Set the admin style
	 *
	 * @param int $value AdminStyle
	 * @return boolean Success
	 */
	public function setAdminStyle ($value) {
		SessionManager::set("sp_admin_style", intval($value));
		return true;
	}

}
