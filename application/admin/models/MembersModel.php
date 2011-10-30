<?php
/**
 * Members model.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Translate error messages
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
	 * @param string $msg Return message
	 */
	public function create ($email, $forename, $surname) {
	
		// basic validation
		if ($email == "" && $forename == "" && $surname == "") {
			$this->setMessage("You must enter some details for the member.");
			return false;
		}
		
		// create a member object
		$member = new Member();
		
		// add data to object
		if (
			!$member->setEmailAddress($email) ||
			!$member->setForename($forename) ||
			!$member->setSurname($surname)
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
		
		$sql = "SELECT * FROM ".DB_PREFIX."members ";
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
