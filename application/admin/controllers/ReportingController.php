<?php
/**
 * Reporting controller
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

class ReportingController extends BaseController implements iController {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Display error logs
	 */
	public function errorlogs () {
	
		// build an error logs module
		require_once("models/ErrorLogsModel.php");
		$errorLogsModel = new ErrorLogsModel();
		
		// output the page
		$this->engine->assign("logs", $errorLogsModel->get());
		$this->engine->display("reporting/errorlogs.tpl");
	
	}
	
	public function index () {
	
		$this->engine->display("reporting/index.tpl");
	
	}

}
