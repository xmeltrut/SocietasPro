<?php
/**
 * Error pages
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Actually look at this class
 */

namespace Controllers;



class ErrorController extends BaseController {

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
	
		$this->engine->assign("title", \Language::getContent("page_not_found"));
		$this->engine->assign("content", \Language::getContent("page_not_found_body"));
		$this->engine->display("errors/404.tpl");
	
	}
	
	/**
	 * 500 Server Error
	 */
	public function serverError () {
	
		$this->engine->assign("title", \Language::getContent("server_error"));
		$this->engine->assign("content", \Language::getContent("server_error_body"));
		$this->engine->display("errors/500.tpl");
	
	}

}
