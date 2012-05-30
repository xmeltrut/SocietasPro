<?php
/**
 * Reporting controller
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

namespace Controllers;

use Model;
use Framework\Abstracts\BaseController;
use Framework\Database\Database;
use Framework\Utilities\Pagination;
use Framework\Http\FrontController;

class ReportingController extends BaseController {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Display audit logs
	 */
	public function auditlogs () {
	
		// get a database instance
		$db = Database::getInstance();
		
		// get a list of actions
		$sql = "SELECT * FROM ".DB_PREFIX."audit_actions ORDER BY actionName ASC ";
		$rec = $db->query($sql);
		
		$actions = array();
		
		while ($row = $rec->fetch()) {
			$actions[$row["actionID"]] = $row["actionLocalised"];
		}
		
		// get a list of members
		$sql = "SELECT * FROM ".DB_PREFIX."members
				WHERE memberPrivileges > 1
				ORDER BY memberSurname ASC, memberForename ASC ";
		$rec = $db->query($sql);
		
		$members = array();
		
		while ($row = $rec->fetch()) {
			$members[$row["memberID"]] = $row["memberSurname"].", ".$row["memberForename"];
		}
		
		// invoke a model
		$auditEntriesModel = new Model\AuditEntriesModel();
		
		// gather variables for page
		$actionID = (isset($_REQUEST["action"])) ? $_REQUEST["action"] : 0;
		$memberID = (isset($_REQUEST["member"])) ? $_REQUEST["member"] : 0;
		$pageNum = Pagination::pageNum(FrontController::getParam(0));
		$totalPages = Pagination::totalPages($auditEntriesModel->count($actionID, $memberID));
		
		// output the page
		$this->engine->assign("actionID", $actionID);
		$this->engine->assign("memberID", $memberID);
		$this->engine->assign("actions", $actions);
		$this->engine->assign("members", $members);
		$this->engine->assign("logs", $auditEntriesModel->get($pageNum, $actionID, $memberID));
		$this->engine->assign("pageNum", $pageNum);
		$this->engine->assign("totalPages", $totalPages);
		$this->engine->display("reporting/auditlogs.tpl");
	
	}
	
	/**
	 * Display error logs
	 */
	public function errorlogs () {
	
		// invoke a model
		$errorLogsModel = new Model\ErrorLogsModel();
		
		// should we filter?
		$code = isset($_REQUEST["code"]) ? $_REQUEST["code"] : false;
		
		// gather variables for page
		$pageNum = Pagination::pageNum(FrontController::getParam(0));
		$totalPages = Pagination::totalPages($errorLogsModel->count($code));
		
		// output the page
		$this->engine->assign("logs", $errorLogsModel->get($code, $pageNum));
		$this->engine->assign("pageNum", $pageNum);
		$this->engine->assign("totalPages", $totalPages);
		$this->engine->display("reporting/errorlogs.tpl");
	
	}
	
	public function index ($request) {
	
		$this->auditlogs();
	
	}

}
