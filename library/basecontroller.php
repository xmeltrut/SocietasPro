<?php
/**
 * Base controller for other controllers to extend from.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

require("classes/TemplateEngine.php");

abstract class BaseController {

	/**
	 * Instance variable to hold template engine object.
	 */
	protected $engine;
	
	/**
	 * Constructor.
	 */
	function __construct () {
	
		$this->engine = new TemplateEngine();
	
	}
	
	/**
	 * This function works out what the user is trying to do when we receive
	 * a mass action request. As they can click any number of different
	 * buttons, we need to search the indexes to see what they are trying to
	 * do
	 *
	 * @return array Action and ID
	 */
	protected function determineMassAction () {
	
		// key keys and search them
		$keys = array_keys($_REQUEST);
		$matches = preg_grep("/(clone|delete)_([0-9]+)/", $keys);
		
		// do we have a match?
		if (count($matches)) {
		
			$values = explode("_", $matches[0]);
			return array ( "action" => $values[0], "ids" => intval($values[1]) );
		
		} else {
		
			if (array_key_exists("ids", $_REQUEST) && array_key_exists("option", $_REQUEST)) {
				if ($_REQUEST["option"] != "") {
					return array ( "action" => $_REQUEST["option"], "ids" => $_REQUEST["ids"] );
				}
			}
			
			return false;
		
		}
	
	}

}