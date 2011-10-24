<?php
/**
 * Wrapper to modify Smarty to our own uses.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

require("smarty/Smarty.class.php");

class TemplateEngine extends Smarty {

	/**
	 * Intercept the constructor so we can set our own variables
	 */
	function __construct () {
	
		parent::__construct();
		
		// @todo Turn on caching
		$this->force_compile = true;
		
		// get the module
		$front = FrontController::getInstance();
		$module = $front->getModule();
		
		if ($module != "") {
			$this->setTemplateDir("../application/".$module."/views/");
		} else {
			die("Unable to initialise template engine, no module defined.");
		}
		
		// set a URL root
		$this->assign("root", ROOT);
		
		// set the standard message to nothing
		$this->assign("msg", "");
		
		// load language strings
		require_once("language.php");
		$language = Language::getInstance();
		$langStrings = $language->getStrings();
		
		foreach ($langStrings as $key => $val) {
			$this->assign("lang_".$key, $val);
		}
	
	}

}
