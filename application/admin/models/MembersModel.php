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
	 * @param string $msg Return message
	 */
	public function create ($email, $forename, $surname, &$msg) {
	
		// basic validation
		if ($email == "" && $forename == "" && $surname == "") {
			$msg = "You must enter some details for the member.";
			return false;
		}
		
		// execute the query
		$sql = "INSERT INTO ".DB_PREFIX."members (
				memberEmail, memberForename, memberSurname
				) VALUES (
				'" . escape($email) . "',
				'" . escape($forename) . "',
				'" . escape($surname) . "'
				)";
		$this->db->query($sql);
		
		// return
		$msg = "The member has been created successfully.";
		return true;
	
	}
	
	
	/**
	 * List members from the database.
	 *
	 * @return array Members
	 */
	public function getMembers () {
	
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
	 */
	public function getMemberById ($id) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."members WHERE memberID = " . $id;
		$rec = $this->db->query($sql);
		$row = $rec->fetch();
		return new Member($row);
	
	}

}
