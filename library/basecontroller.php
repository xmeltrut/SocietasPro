<?php
/**
 * Base controller for other controllers to extend from.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

require("templateengine.php");

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

}