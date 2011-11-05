<?php
/**
 * Front controller.
 *
 * @author Chris Worfolk <chris@societaspro.org
 * @package SocietasPro
 * @subpackage Core
 *
 * @todo If you mispell the module name, it needs to throw an error
 * @todo Need to add validation to the controller variable
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
		set_include_path(get_include_path() . PATH_SEPARATOR . $path); // @todo Tidy this up
		
		$controllerName = $this->getController();
		$controllerFile = $controllerName . ".php";
		$controllerPath = $path . "controllers/" . $controllerFile;
		
		if (!file_exists($controllerPath)) {
			include_once("exceptions/HttpErrorException.php");
			throw new HttpErrorException(404);
		}
		
		include($controllerPath);
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
		
		// extract variables
		$vars = explode("/", $url);
		
		// assign variables
		$module = (isset($vars[1])) ? $vars[1] : "";
		self::setModule($module);
		
		self::$controller = (isset($vars[2])) ? $vars[2] : "";
		self::$page = (isset($vars[3])) ? $vars[3] : "";
		
		// rest are parameters
		for ($i = 0; $i < count($vars); $i++) {
			if ($i > 3) {
				self::$params[] = $vars[$i];
			}
		}
	
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
			return true;
		}
		
		return false;
	
	}

}
