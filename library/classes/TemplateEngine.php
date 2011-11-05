<?php
/**
 * Wrapper to modify Smarty to our own uses.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 *
 * @todo Put a wrapper on display in case of Smarty exceptions
 * @todo Turn on caching on production systems
 */

require("smarty/Smarty.class.php");

class TemplateEngine extends Smarty {

	/**
	 * Intercept the constructor so we can set our own variables
	 */
	function __construct () {
	
		parent::__construct();
		
		$this->force_compile = true;
		
		// get the module
		$front = FrontController::getInstance();
		$module = $front->getModule();
		
		if ($module == "public") {
			$this->setTemplateDir("../personalisation/themes/default/");
		} elseif ($module != "") {
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

}
