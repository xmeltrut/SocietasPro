<?php
/**
 * Wrapper to modify Smarty to our own uses.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

namespace Framework\Http;

use Framework\Http\FrontController;
use Framework\Security\Authorisation;
use Exceptions\TemplateException;
use Framework\Language\Language;
use Framework\Core\Configuration;
use Framework\Core\Kernel;

require("vendors/smarty/Smarty.class.php");

class TemplateEngine extends \Smarty {

	/**
	 * Intercept the constructor so we can set our own variables
	 */
	function __construct () {
	
		parent::__construct();
		
		// force recompile when developing
		if (MODE == "DEBUG") {
			$this->force_compile = true;
		} else {
			$tmp = new TmpGateway();
			if ($tmp->getPath()) {
				$this->compile_dir = $tmp->getPath()."/cache/smarty";
			} else {
				// @todo This is a tempory solution
				// @todo This doesn't work anyway
				$this->compile_dir = "cache/smarty";
			}
		}
		
		// get the module
		$front = FrontController::getInstance();
		
		$this->setTemplateDir("application/Views/");
		$this->assign("controller", strtolower(substr($front->getController(), 0, -10)));
		$this->assign("section", $front->getPage());
		
		// load language strings
		$language = Language::getInstance();
		$langStrings = $language->getStrings();
		
		foreach ($langStrings as $key => $val) {
			$this->assign("lang_".$key, $val);
		}
		
		// assign some generic variables
		$this->assign("root", ROOT);
		$this->assign("group_name", Configuration::get("group_name"));
		$this->assign("version", Kernel::VERSION);
		
		// is the install directory present?
		if (file_exists("install/") && MODE == "LIVE") {
			$this->assign("installDir", true);
			$this->assign("installDirMsg", Language::getContent("install_directory_exists"));
		} else {
			$this->assign("installDir", false);
		}
		
		// user login details
		$auth = Authorisation::getInstance();
		$this->assign("session_admin_style", $auth->getAdminStyle());
		
		// set the standard message to nothing
		$this->setMessage("");
	
	}
	
	/**
	 * Assign a variable. This just calls the parent function, barring
	 * a few checks on our end.
	 */
	public function assign ($tplVar, $value = null, $noCache = false) {
		if ($tplVar == "msg") {
			throw new TemplateException('You can assign $msg directly');
		} else {
			parent::assign($tplVar, $value, $noCache);
		}
	}
	
	/**
	 * Outputs a template
	 *
	 * @param string $template Template name
	 * @param mixed $cache_id Cache ID
	 * @param mixed $compile_id Compile ID
	 * @param object $parent
	 */
	public function display ($template, $cache_id = null, $compile_id = null, $parent = null) {
	
		try {
			parent::display($template, $cache_id, $compile_id, $parent);
		} catch (SmartyException $e) {
			throw new TemplateException($e->getMessage());
		}
	
	}
	
	/**
	 * Set the message/notice at the top of the page
	 *
	 * @param string|array $msg Can be string or array of strings
	 */
	public function setMessage ($msg) {
	
		if (is_array($msg)) {
			$msgCode  = "<ul>";
			foreach ($msg as $str) {
			$msgCode .= "<li>".$str."</li>";
			}
			$msgCode .= "</ul>";
		} elseif ($msg != "") {
			$msgCode = "<ul><li>".$msg."</li></ul>";
		} else {
			$msgCode = "";
		}
		
		parent::assign("msg", $msgCode);
	
	}

}
