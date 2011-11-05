<?php
/**
 * Error logs model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

require_once("basemodel.php");
require_once("objects/Page.php");

class ErrorLogsModel extends BaseModel {

	protected $tableName = "error_logs";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Get the most recent error logs.
	 *
	 * @return Associative array
	 */
	public function get () {
	
		// initialise array
		$arr = array();
		
		// query database
		$sql = "SELECT * FROM ".DB_PREFIX."error_logs
				ORDER BY logDate DESC LIMIT 0, 100";
		$rec = $this->db->query($sql);
		
		// loop through results
		while ($row = $rec->fetch()) {
			$arr[] = $row;
		}
		
		// return array
		return $arr;
	
	}
	
	/**
	 * Insert a new error log
	 *
	 * @param $code int Error code
	 * @param $details string Error details
	 * @param $sql SQL statement
	 * @return boolean Success
	 */
	public function insert ($code, $details = "", $sql = "") {
	
		$sql = "INSERT INTO ".DB_PREFIX."error_logs (
			logCode, logURL, logDate, logDetails, logSQL
			) VALUES (
			".$code.",
			'".escape($_SERVER["REQUEST_URI"])."',
			NOW(),
			'".escape($details)."',
			'".escape($sql)."'
			)";
		return $this->db->query($sql);
	}

}