<?php
/**
 * Outputs resources
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Public
 *
 * @todo Resources should use current theme
 * @todo Add validation
 */

namespace publica;

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
	 * Images directory
	 */
	public function images () {
	
		$code = file_get_contents("../personalisation/themes/".\Configuration::get("theme")."/images/".\FrontController::getParam(0), true);
		Header("content-type: image/png");
		print $code;
	
	}
	
	/**
	 * Get the main stylesheet
	 */
	public function style () {
	
		$code = file_get_contents("../personalisation/themes/".\Configuration::get("theme")."/style.css", true);
		Header("content-type: text/css");
		print $code;
	
	}


}