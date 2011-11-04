<?php
/**
 * Members model.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo We need to implement edit functions on models
 * @todo Check if email addresses are well formed (create and edit)
 */

require_once("basemodel.php");
require_once("objects/member.php");

class MembersModel extends BaseModel {

	protected $tableName = "members";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * List members from the database.
	 *
	 * @param int $pageNum Page number
	 * @param int $perPage Items per page
	 * @return array Members
	 */
	public function get ($pageNum = 1, $perPage = ITEMS_PER_PAGE) {
	
		// initialise an array
		$members = array();
		
		// build SQL
		$sql = "SELECT * FROM ".DB_PREFIX."members ".sqlLimit($pageNum, $perPage);
		
		// query database
		$rec = $this->db->query($sql);
		
		// build array
		while ($row = $rec->fetch()) {
			$members[] = new Member($row);
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
			return new Member($row);
		} else {
			return false;
		}
	
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
		if (
			!$object->setEmailAddress($d["email"]) ||
			!$object->setForename($d["forename"]) ||
			!$object->setSurname($d["surname"]) ||
			!$object->setAddress($d["address"]) ||
			!$object->setNotes($d["notes"])
		) {
			$this->setMessage($object->getMessage());
			return false;
		}
		
		// record in audit trail
		auditTrail($auditAction, $object->original(), $object);
		
		// save object
		$this->setMessage(LANG_SUCCESS);
		return $this->save($object);
	
	}

}
