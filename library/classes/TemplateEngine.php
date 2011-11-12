<?php
/**
 * Wrapper to modify Smarty to our own uses.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 *
 * @todo Implemented overloaded assign() funciton to check for disallowed names
 * @todo Implement setMessage() function to assign the message
 * @todo Update codebase to use setMessage() function
 */

require("smarty/Smarty.class.php");

class TemplateEngine extends Smarty {

	/**
	 * Intercept the constructor so we can set our own variables
	 */
	function __construct () {
	
		parent::__construct();
		
		// force recompile when developing
		if (MODE == "DEBUG") {
			$this->force_compile = true;
		}
		
		// get the module
		$front = FrontController::getInstance();
		$module = $front->getModule();
		
		if ($module == "public") {
			$this->setTemplateDir("../personalisation/themes/default/");
		} elseif ($module != "admin") {
			$this->setTemplateDir("../application/".$module."/views/");
		} else {
			require("exceptions/TemplateException.php");
			throw new TemplateException("Unable to initialise template engine, no module defined.");
		}
		
		// set a URL root
		$this->assign("root", ROOT);
		
		// set the standard message to nothing
		$this->assign("msg", "");
		
		// load language strings
		$language = Language::getInstance();
		$langStrings = $language->getStrings();
		
		foreach ($langStrings as $key => $val) {
			$this->assign("lang_".$key, $val);
		}
	
	}
	
	/**
	 * Assign a variable
	 *
	 * @param mixed $var1 Name of variable
	 * @param mixed $var2 Value
	 */
	//public function assign ($var1, $var2 = false) {
	//}
	
	/**
	 * Outputs a template
	 *
	 * @param string $template Template name
	 * @param string $cache_id Cache ID
	 * @param string $compile_id Compile ID
	 */
	public function display ($template, $cache_id = false, $compile_id = false) {
	
		try {
			parent::display($template, $cache_id, $compile_id);
		} catch (Exception $e) {
			require_once("exceptions/TemplateException.php");
			throw new TemplateException();
		}
	
	}
	
	/**
	 * Set the message/notice at the top of the page
	 *
	 * @param mixed $msg Can be string or array of strings
	 */
	public function setMessage ($msg) {
	
		
	
	}

}
