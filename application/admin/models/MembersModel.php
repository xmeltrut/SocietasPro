<?php
/**
 * Members model.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("basemodel.php");
require_once("objects/member.php");

class MembersModel extends BaseModel {

	protected $tableName = "members";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Create a member
	 *
	 * @param string $email Email address
	 * @param string $forename Forename
	 * @param string $surname Surname
	 * @param string $address Address
	 * @param string $notes Notes
	 * @param string $msg Return message
	 */
	public function create ($email, $forename, $surname, $address, $notes) {
	
		// basic validation
		if ($email == "" && $forename == "" && $surname == "") {
			$this->setMessage(strFirst(LANG_INVALID." ".LANG_NAME.", ".LANG_EMAIL));
			return false;
		}
		
		// create a member object
		$member = new Member();
		
		// add data to object
		if (
			!$member->setEmailAddress($email) ||
			!$member->setForename($forename) ||
			!$member->setSurname($surname) ||
			!$member->setAddress($address) ||
			!$member->setNotes($notes)
		) {
			$this->setMessage($member->getMessage());
			return false;
		}
		
		// save object
		return $this->save($member);
	
	}
	
	/**
	 * List members from the database.
	 *
	 * @return array Members
	 */
	public function get () {
	
		$members = array();
		
		$sql = "SELECT * FROM ".DB_PREFIX."members2 ";
		$rec = $this->db->query($sql);
		
		while ($row = $rec->fetch()) {
			$members[] = new Member($row);
		}
		
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

}
