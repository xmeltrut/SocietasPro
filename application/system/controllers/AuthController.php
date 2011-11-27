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
		$this->engine->assign("forgotten_your_password", \Language::getContent("forgotten_your_password"));
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
	
	/**
	 * Reset your password
	 */
	public function reset () {
	
		// create a members model
		require_once("models/MembersModel.php");
		$membersModel = new \MembersModel();
		
		// check which page we are on
		if (reqSet("email") != "" && reqSet("key") != "") {
		
			$newPassword = "";
			
			if ($member = $membersModel->getByEmail($_REQUEST["email"])) {
				if (md5($member->memberPasswordResetKey) == reqSet("key")) {
				
					// ok, reset their password
					$newPassword = strRandom(8);
					
					$member->setPassword($newPassword);
					$member->setPasswordResetKey("");
					$membersModel->save($member);
				
				}
			}
			
			if ($newPassword == "") {
			
				$msg = strFirst(LANG_INVALID." ".LANG_DETAILS);
			
			} else {
			
				$msg = \Language::getContent("new_password");
				$msg = str_replace("%%PASSWORD%%", "<strong>".$newPassword."</strong>", $msg);
			
			}
			
			$this->engine->assign("message", $msg);
		
		} elseif (reqSet("action") == "reset" && reqSet("email") != "") {
		
			// get the member
			$member = $membersModel->getByEmail(reqSet("email"));
			
			if ($member) {
			
				// set a random key on their account
				$passwordKey = strRandom(12);
				$member->setPasswordResetKey($passwordKey);
				$membersModel->save($member);
				
				// build email variables
				$body = \Language::getContent("password_reset_email")."\n\n".
						"http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]."?email=".urlencode($member->memberEmail).
						"&key=".md5($passwordKey);
				
				// send email
				$mail = new \Mailer();
				$mail->addRecipient(reqSet("email"));
				$mail->setSubject(LANG_PASSWORD." ".LANG_RESET);
				$mail->setBody($body);
				
				if ($mail->send()) {
				
					$msg = \Language::getContent("email_sent");
				
				} else {
				
					$msg = LANG_FAIL;
				
				}
			
			} else {
			
				$msg = strFirst(LANG_INVALID." ".LANG_EMAIL_ADDRESS);
			
			}
			
			$this->engine->assign("message", $msg);
		
		} else {
		
			$this->engine->assign("message", "");
		
		}
		
		// display page
		$this->engine->display("auth/reset.tpl");
	
	}

}
