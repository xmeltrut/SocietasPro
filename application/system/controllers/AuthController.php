<?php
/**
 * Authorisation actions
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage System
 */

namespace system;

class AuthController extends \BaseController implements \iController {

	/**
	 * Default page
	 */
	public function index () {
		$this->login();
	}
	
	/**
	 * Login page
	 */
	public function login () {
	
		// check for actions
		if (reqSet("action") == "login") {
			$auth = \Authorisation::getInstance();
			$rv = $auth->login($_REQUEST["email"], $_REQUEST["password"], $msg);
			
			if ($rv) {
				redirect("admin");
			}
		}
		
		// display page
		$this->engine->display("auth/login.tpl");
	
	}
	
	/**
	 * Log a user out
	 */
	public function logout () {
	
		$auth = \Authorisation::getInstance();
		$auth->logout();
		redirect();
	
	}

}
