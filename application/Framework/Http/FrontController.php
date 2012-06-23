<?php
/**
 * Front controller.
 *
 * @author Chris Worfolk <chris@societaspro.org
 * @package SocietasPro
 * @subpackage Core
 *
 * @todo Modules are still in URL, but other code is removed
 */

namespace Framework\Http;

use Framework\Core\Singleton;
use Framework\Security\Authorisation;

class FrontController extends Singleton {

	/**
	 * Variable to hold single instance
	 */
	private static $instance;
	
	/**
	 * Variables to hold URL parameters
	 */
	private static $controller;
	private static $page;
	private static $params;
	
	/**
	 * Execute a page request
	 */
	public function execute () {
	
		// authorisation
		$auth = Authorisation::getInstance();
		if (!$auth->isLoggedIn() && $this->getController() != "AuthController") {
			redirect("system/auth/login");
		}
		
		// create the controller
		$controllerName = "\Controllers\\".$this->getController();
		$controller = new $controllerName;
		
		$page = $this->getPage();
		
		/*if (!is_callable(array($controller, $page))) {
			throw new HttpErrorException(404);
		}*/
		
		$controller->$page(new Request());
	
	}
	
	/**
	 * Get the requested controller.
	 *
	 * @return string Controller
	 */
	public function getController () {
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
	 * Get the requested page
	 *
	 * @param string Page
	 */
	public function getPage () {
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
	
		// requested uri
		$requestedUri = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : "/";
		
		// get the requested URI
		if (ROOT == "/") {
			// mod_rewrite
			$url = $requestedUri;
		} else {
			// we're not using mod_rewrite
			$url = str_replace(ROOT, "", $requestedUri);
		}
		
		// remove any querystring
		if (($pos = strpos($url, "?")) !== false) {
			$url = substr($url, 0, $pos);
		}
		
		// extract variables
		$vars = explode("/", $url);
		
		// assign variables
		$controller = (isset($vars[1])) ? $vars[1] : "";
		self::setController($controller);
		
		$page = (isset($vars[2])) ? $vars[2] : "";
		self::setPage($page);
		
		// rest are parameters
		for ($i = 0; $i < count($vars); $i++) {
			if ($i > 2) {
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

