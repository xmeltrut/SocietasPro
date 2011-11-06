<?php
/**
 * Error pages
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Translate error message pages
 * @todo Map ErrorDocuments in .htaccess to here
 */

class ErrorController extends BaseController implements iController {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * No default page, send to 500
	 */
	public function index () {
		$this->serverError();
	}
	
	/**
	 * 404 Page Not Found
	 */
	public function notFound () {
		$this->engine->display("errors/404.tpl");
	}
	
	/**
	 * 500 Server Error
	 */
	public function serverError () {
		$this->engine->display("errors/500.tpl");
	}

}
