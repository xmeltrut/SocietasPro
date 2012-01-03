<?php
/**
 * Error logs model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

class ErrorLogsModel extends BaseModel {

	protected $tableName = "error_logs";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Count the number of log entries
	 *
	 * @param int $code Code to filter on
	 * @return int Log entries
	 */
	public function count ($code = false) {
	
		$sql = "SELECT COUNT(logID) FROM ".DB_PREFIX."error_logs ";
		if ($code !== false) {
			$sql .= "WHERE logCode = ".$code;
		}
		return $this->db->fetchOne($sql);
	
	}
	
	/**
	 * Get the most recent error logs.
	 *
	 * @param int $code Code to filter on
	 * @param int $pageNum Page number
	 * @return Associative array
	 */
	public function get ($code = false, $pageNum = 1) {
	
		// initialise array
		$arr = array();
		
		// filtering code
		if ($code !== false) {
			$filter = "WHERE logCode = ".$code." ";
		} else {
			$filter = "";
		}
		
		// query database
		$sql = "SELECT * FROM ".DB_PREFIX."error_logs
				$filter
				ORDER BY logDate DESC ".sqlLimit($pageNum);
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
			'".$this->db->escape($_SERVER["REQUEST_URI"])."',
			NOW(),
			'".$this->db->escape($details)."',
			'".$this->db->escape($sql)."'
			)";
		return $this->db->query($sql);
	}

}
