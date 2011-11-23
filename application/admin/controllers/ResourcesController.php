<?php
/**
 * Used to access dynamic resources
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

namespace admin;

class ResourcesController extends \BaseController implements \iController {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Images
	 */
	public function images () {
	
		$image = \FrontController::getParam(0);
		$imagePath = "../application/admin/resources/images/".$image;
		
		if (file_exists($imagePath)) {
			header("Content-type: " . mime_content_type($imagePath));
			$data = file_get_contents($imagePath);
			print $data;
		} else {
			throw new \HttpErrorException(404);
		}
	
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
	
		$code = file_get_contents("resources/admin.css", true);
		Header("content-type: text/css");
		print $code;
	
	}

}
