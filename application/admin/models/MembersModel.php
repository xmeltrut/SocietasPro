<?php
/**
 * Members model.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("objects/Member.php");

class MembersModel extends BaseModel implements iModel {

	protected $tableName = "members";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Count the total number of members
	 *
	 * @return int Number of members
	 */
	public function count () {
	
		$sql = "SELECT COUNT(memberID) FROM ".DB_PREFIX."members ";
		return $this->db->fetchOne($sql);
	
	}
	
	/**
	 * List members from the database.
	 *
	 * @param int $pageNum Page number
	 * @param int $perPage Items per page
	 * @return array Members
	 */
	public function get ($pageNum = 1) {
	
		// initialise an array
		$members = array();
		
		// build SQL
		$sql = "SELECT * FROM ".DB_PREFIX."members ".sqlLimit($pageNum);
		
		// query database
		$rec = $this->db->query($sql);
		
		// build array
		while ($row = $rec->fetch()) {
			$members[] = new Member($row, $this->getCustomData($row["memberID"]));
		}
		
		// return results
		return $members;
	
	}
	
	/**
	 * Get a specific member
	 *
	 * @param int $id Member ID
	 * @return Member
	 */
	public function getById ($id) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."members WHERE memberID = " . $id;
		$rec = $this->db->query($sql);
		
		if ($row = $rec->fetch()) {
			return new Member($row, $this->getCustomData($id));
		} else {
			return false;
		}
	
	}
	
	/**
	 * Get custom data for a member
	 *
	 * @param int $id ID of member
	 * @return array Array
	 */
	private function getCustomData ($id) {
	
		// initialise an array
		$arr = array();
		
		// query the database
		$sql = "SELECT * FROM ".DB_PREFIX."members_data
				WHERE dataMember = ".$id;
		$rec = $this->db->query($sql);
		
		// loop through results
		while ($row = $rec->fetch()) {
			$arr[$row["dataField"]] = $row["dataValue"];
		}
		
		// return array
		return $arr;
	
	}
	
	/**
	 * Get a list of email addresses as an array
	 *
	 * @return array Members' email addresses
	 */
	public function getEmailsAsArray () {
	
		// initialise array
		$arr = array();
		
		// query the database
		$sql = "SELECT memberEmail FROM ".DB_PREFIX."members ";
		$rec = $this->db->query($sql);
		
		// loop through results
		while ($row = $rec->fetch()) {
			if (!in_array($row["memberEmail"], $arr)) {
				$arr[] = $row["memberEmail"];
			}
		}
		
		// and return
		return $arr;
	
	}
	
	/**
	 * Get a specific privilege
	 *
	 * @param int $id Privilege ID
	 * @return string Privilege name
	 */
	public function getPrivilege ($id) {
	
		$privileges = $this->getPrivileges();
		return $privileges[$id];
	
	}
	
	/**
	 * Get an array of the possible privileges
	 *
	 * @return array Associative array
	 */
	public function getPrivileges () {
	
		return array (
			1 => LANG_MEMBER,
			2 => LANG_ADMINISTRATOR
		);
	
	}
	
	/**
	 * Save function to include custom data as well
	 *
	 * @param Member $obj Member object
	 * @return boolean Success
	 */
	public function save ($obj) {
	
		$customData = $obj->getAllCustomData();
		$result = parent::save($obj);
		
		if ($result) {
		
			foreach ($customData as $key => $val) {
			
				$sql = "SELECT dataField FROM ".DB_PREFIX."members_data
						WHERE dataMember = ".$obj->memberID."
						AND dataField = ".$key;
				$sea = $this->db->query($sql);
				
				if ($sea->getRows() == 1) {
			
					$sql = "UPDATE ".DB_PREFIX."members_data
							SET dataValue = '".escape($val)."'
							WHERE dataMember = ".$obj->memberID."
							AND dataField = ".$key;
					$this->db->query($sql);
				
				} else {
				
					$sql = "INSERT INTO ".DB_PREFIX."members_data (
							dataMember, dataField, dataValue
							) VALUES (
							".$obj->memberID.",".$key.",'".escape($val)."'
							)";
					$this->db->query($sql);
				
				}
			}
		
		}
		
		return $result;
	
	}
	
	/**
	 * Edit or create a member
	 *
	 * @param array $d Data
	 * @param int $id ID or false if creating
	 * @return boolean Success
	 */
	public function write ($d, $id = false) {
	
		// get object
		if ($id) {
			$object = $this->getById($id);
			$auditAction = 2;
		} else {
			$object = new Member();
			$auditAction = 1;
		}
		
		// make modifications
		$writes = array (
			$object->setEmailAddress($d["email"]),
			$object->setForename($d["forename"]),
			$object->setSurname($d["surname"]),
			$object->setPrivileges($d["privileges"]),
			$object->setPassword($d["password"]),
			$object->setAddress($d["address"]),
			$object->setNotes($d["notes"])
		);
		
		// modify custom data
		$membersFieldsModel = new MembersFieldsModel();
		$fields = $membersFieldsModel->getAsArray();
		foreach ($fields as $key => $val) {
			$object->setCustomData($key, $d["custom".$key]);
		}
		
		// check response
		if (in_array(false, $writes)) {
			$this->setMessage($object->getMessage());
			if ($id === false) { return false; }
		}
		
		if ($object->hasChanged()) {
			if ($this->save($object)) {
				auditTrail($auditAction, $object->original(), $object);
				$this->setMessage(LANG_SUCCESS);
				return true;
			}
		}
		
		return false;
	
	}

}
