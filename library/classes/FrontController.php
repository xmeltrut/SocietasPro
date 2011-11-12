<?php
/**
 * Front controller.
 *
 * @author Chris Worfolk <chris@societaspro.org
 * @package SocietasPro
 * @subpackage Core
 *
 * @todo Implement some kind of namespace alias systems (hacked at the moment)
 */

class FrontController {

	/**
	 * Variable to hold single instance
	 */
	private static $instance;
	
	/**
	 * Variables to hold URL parameters
	 */
	private static $module;
	private static $moduleError;
	private static $controller;
	private static $page;
	private static $params;
	
	/**
	 * Constructor
	 */
	private function __construct () {
	}
	
	/**
	 * Execute a page request
	 */
	public function execute () {
	
		$path = "../application/".$this->getModule()."/";
		set_include_path(get_include_path() . PATH_SEPARATOR . $path);
		
		if (self::$moduleError === true) {
			self::setController("ErrorController");
			self::setPage("404");
		}
		
		$controllerName = $this->getController();
		$controllerFile = $controllerName . ".php";
		$controllerPath = $path . "controllers/" . $controllerFile;
		
		if (!file_exists($controllerPath)) {
			include_once("exceptions/HttpErrorException.php");
			throw new HttpErrorException(404);
		}
		
		include($controllerPath);
		
		// create the controller
		$module = str_replace("public", "publica", $this->getModule());
		$controllerName = "\\".$module."\\".$controllerName;
		$controller = new $controllerName();
		
		$page = $this->getPage();
		
		if (!is_callable(array($controller, $page))) {
			include_once("exceptions/HttpErrorException.php");
			throw new HttpErrorException(404);
		}
		
		$controller->$page();
	
	}
	
	/**
	 * Get the requested controller.
	 *
	 * @return string Controller
	 */
	private function getController () {
		if (self::$controller == "") {
			self::$controller = "Default";
		}
		return ucfirst(self::$controller) . "Controller";
	}
	
	/**
	 * Singleton
	 */
	public static function getInstance () {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
			self::parseVariables();
		}
		return self::$instance;
	}
	
	/**
	 * Get the requested module
	 *
	 * @return string Module
	 */
	public function getModule () {
		if (self::$module == "") {
			self::$module = "public";
		}
		return self::$module;
	}
	
	/**
	 * Get the requested page
	 *
	 * @param string Page
	 */
	private function getPage () {
		if (self::$page == "") {
			self::$page = "index";
		}
		return self::$page;
	}
	
	/**
	 * Get a parameter
	 *
	 * @param int $index Index, starting at 0
	 * @return mixed
	 */
	public function getParam ($index) {
		if (isset(self::$params[$index])) {
			return self::$params[$index];
		} else {
			return false;
		}
	}
	
	/**
	 * Parse variables
	 */
	private function parseVariables () {
	
		// get the requested URI
		if (ROOT == "/") {
			// mod_rewrite
			$url = $_SERVER["REQUEST_URI"];
		} else {
			// we're not using mod_rewrite
			$url = str_replace(ROOT, "", $_SERVER["REQUEST_URI"]);
		}
		
		// remove any querystring
		if (($pos = strpos($url, "?")) !== false) {
			$url = substr($url, 0, $pos);
		}
		
		// extract variables
		$vars = explode("/", $url);
		
		// assign variables
		$module = (isset($vars[1])) ? $vars[1] : "";
		self::setModule($module);
		
		$controller = (isset($vars[2])) ? $vars[2] : "";
		self::setController($controller);
		
		$page = (isset($vars[3])) ? $vars[3] : "";
		self::setPage($page);
		
		// rest are parameters
		for ($i = 0; $i < count($vars); $i++) {
			if ($i > 3) {
				self::$params[] = $vars[$i];
			}
		}
	
	}
	
	/**
	 * Set the controller.
	 *
	 * @param string $name Controller name
	 * @return boolean Success
	 */
	private function setController ($name) {
	
		$name = strSantiseFilename($name);
		self::$controller = $name;
		return true;
	
	}
	
	/**
	 * Set the module. There are only three modules, so we might
	 * as well just hard code this as an array to check against
	 * for performance reasons.
	 *
	 * @param string $name Module name
	 * @return boolean Success
	 */
	private function setModule ($name) {
	
		$validModules = array ("admin", "public", "system");
		
		if ($name == "" || in_array($name, $validModules)) {
			self::$module = $name;
			self::$moduleError = false;
			return true;
		}
		
		self::$moduleError = true;
		return false;
	
	}
	
	/**
	 * Set the page.
	 *
	 * @param string $name Page name
	 * @return boolean Success
	 */
	private function setPage ($name) {
	
		$name = strSantiseFilename($name);
		self::$page = $name;
		return true;
	
	}

}
