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
		
		// force recompile when developing
		if (MODE == "DEBUG") {
			$this->force_compile = true;
		}
		
		// get the module
		$front = FrontController::getInstance();
		$module = $front->getModule();
		
		if ($module == "public") {
			$this->setTemplateDir("../personalisation/themes/default/");
			$this->assign("current_year", date("Y"));
			require("models/PagesModel.php");
			$pagesModel = new PagesModel();
			$this->assign("menu", $pagesModel->get());
		} elseif ($module != "") {
			$this->setTemplateDir("../application/".$module."/views/");
			$this->assign("controller", strtolower(substr($front->getController(), 0, -10)));
			$this->assign("section", $front->getPage());
		} else {
			throw new TemplateException("Unable to initialise template engine, no module defined.");
		}
		
		// assign some generic variables
		$this->assign("root", ROOT);
		$this->assign("group_name", Configuration::get("group_name"));
		$this->assign("version", SP_VERSION);
		
		// set the standard message to nothing
		$this->setMessage("");
		
		// load language strings
		$language = Language::getInstance();
		$langStrings = $language->getStrings();
		
		foreach ($langStrings as $key => $val) {
			$this->assign("lang_".$key, $val);
		}
	
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
	 * @param string $cache_id Cache ID
	 * @param string $compile_id Compile ID
	 */
	public function display ($template, $cache_id = false, $compile_id = false) {
	
		try {
			parent::display($template, $cache_id, $compile_id);
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
