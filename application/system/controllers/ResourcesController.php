<?php
/**
 * Used to access dynamic resources
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage System
 */

namespace system;

class ResourcesController extends \BaseController implements \iController {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * There is no default to access, so throw a 404
	 */
	public function index () {
		throw new \HttpErrorException(404);
	}
	
	/**
	 * Get the main stylesheet
	 */
	public function style () {
	
		$code = file_get_contents("resources/system.css", true);
		Header("content-type: text/css");
		print $code;
	
	}

}
