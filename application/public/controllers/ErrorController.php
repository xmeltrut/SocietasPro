<?php
/**
 * Error pages
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Public
 */

namespace publica;

class ErrorController extends \BaseController implements \iController {

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
		$this->engine->display("404.tpl");
	}
	
	/**
	 * 500 Server Error
	 */
	public function serverError () {
		$this->engine->display("500.tpl");
	}

}