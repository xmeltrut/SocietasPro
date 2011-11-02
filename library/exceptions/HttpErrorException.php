<?php
/**
 * Standard HTTP error exceptions
 *
 * @author Chris Worfolk <chris@buzzsports.com>
 * @package SocietasPro
 * @subpackage Exceptions
 */

class HttpErrorException extends Exception {

	/**
	 * Instance of the ErrorController for outputting an error page
	 */
	private $errorController;
	
	/**
	 * Override the parent constructor
	 *
	 * @param int $code HTTP status code
	 */
	function __construct($code) {
	
		// invoke error controller
		require_once("controllers/errorcontroller.php");
		$this->errorController = new ErrorController();
		
		// switch between error codes
		switch ($code) {
			case 404:
				$this->notFound();
				break;
			default:
				$this->serverError(); // we also default to 500
		}
		
		// and exit with an error
		exit(1);
	
	}
	
	/**
	 * 404 page not found
	 */
	public function notFound () {
		header("HTTP/1.1 404 Not Found");
		$this->errorController->notFound();
	}
	
	/**
	 * 500 server error
	 */
	public function serverError () {
		header('HTTP/1.1 500 Internal Server Error');
		$this->errorController->serverError();
	}

}
