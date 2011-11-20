<?php
/**
 * Used to access dynamic resources
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Move all resources under this controller
 */

namespace admin;

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
	 * Get the main admin javascript file
	 */
	public function js () {
	
		$js = file_get_contents("resources/admin.js", true);
		$js = str_replace('{$lang_are_you_sure}', LANG_ARE_YOU_SURE, $js);
		Header("content-type: text/javascript");
		print $js;
	
	}
	
	/**
	 * Get the main stylesheet
	 */
	public function style () {
	
		$js = file_get_contents("resources/admin.css", true);
		Header("content-type: text/css");
		print $js;
	
	}

}