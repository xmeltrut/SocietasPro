<?php
/**
 * Audit entries model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Action needs to be translated
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
		$sql = "SELECT ae.*, m.memberForename, m.memberSurname, m.memberEmail, aa.actionName
				FROM ".DB_PREFIX."audit_entries AS ae
				LEFT OUTER JOIN ".DB_PREFIX."members AS m
				ON ae.entryMember = m.memberID
				LEFT OUTER JOIN ".DB_PREFIX."audit_actions AS aa
				ON ae.entryAction = aa.actionID
				ORDER BY entryDate DESC ".sqlLimit($pageNum);
		$rec = $this->db->query($sql);
		
		// loop through results
		while ($row = $rec->fetch()) {
		
			// member information
			if ($row["memberEmail"] === NULL) {
				$row["entryMember"] = "";
			} else {
				$row["entryMember"] = h($row["memberForename"]." ".$row["memberSurname"]." <".$row["memberEmail"].">");
			}
			
			// action information
			
			
			// save row into array
			$arr[] = $row;
		
		}
		
		// return array
		return $arr;
	
	}
	
	/**
	 * Insert a new entry into the log. This should only be used by the
	 * auditTrail() function!
	 *
	 * @param int $actionID Action ID
	 * @param string $oldData Original data
	 * @param string $newData Updated data
	 */
	public function insert ($actionID, $oldData = "", $newData = "") {
	
		// grab the user ID
		$memberID = intval($_SESSION["sp_user_id"]);
		
		// insert into database
		$sql = "INSERT INTO ".DB_PREFIX."audit_entries (
				entryAction, entryMember, entryDate, entryOldData, entryNewData
				) VALUES (
				".$actionID.",
				".$memberID.",
				NOW(),
				'".escape($oldData)."',
				'".escape($newData)."'
				)";
		return $this->db->query($sql);
	
	}

}
