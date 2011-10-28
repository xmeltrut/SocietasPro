<?php
/**
 * Authorisation actions
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage System
 *
 * @todo Check if 404 and 500 errors work (they probably won't)
 */

class AuthController extends BaseController implements iController {

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
			require("authorisation.php");
			$auth = Authorisation::getInstance();
			$rv = $auth->login($_REQUEST["email"], $_REQUEST["password"], $msg);
			
			if ($rv) {
				redirect("admin");
			}
		}
		
		// display page
		$this->engine->display("login.tpl");
	
	}
	
	/**
	 * Log a user out
	 */
	public function logout () {
	
		require("authorisation.php");
		$auth = Authorisation::getInstance();
		$auth->logout();
		redirect("");
	
	}

}
