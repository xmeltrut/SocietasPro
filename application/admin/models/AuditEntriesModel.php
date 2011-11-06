<?php
/**
 * Audit entries model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("basemodel.php");

class AuditEntriesModel extends BaseModel {

	protected $tableName = "audit_entries";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Count the number of log entries
	 *
	 * @return int Log entries
	 */
	public function count () {
	
		$sql = "SELECT COUNT(entryID) FROM ".DB_PREFIX."audit_entries ";
		return $this->db->fetchOne($sql);
	
	}
	
	/**
	 * Get the most recent audit entries
	 *
	 * $param int $pageNum Page number
	 * @return Associative array
	 */
	public function get ($pageNum = 1) {
	
		// initialise array
		$arr = array();
		
		// query database
		$sql = "SELECT * FROM ".DB_PREFIX."audit_entries
				ORDER BY entryDate DESC ".sqlLimit($pageNum);
		$rec = $this->db->query($sql);
		
		// loop through results
		while ($row = $rec->fetch()) {
			$arr[] = $row;
		}
		
		// return array
		return $arr;
	
	}

}
