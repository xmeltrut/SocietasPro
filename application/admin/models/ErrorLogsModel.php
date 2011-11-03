<?php
/**
 * Error logs model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Can we use this to create error logs?
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

}
