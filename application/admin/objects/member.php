<?php
/**
 * Member object.
 *
 * @author Chris Worfolk <chris@societaspro.org
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("baseobject.php");

class Member extends BaseObject {

	function __construct ($data = array()) {
		parent::__construct($data);
	}
	
	public function setEmailAddress ($value) {
		$this->setData("memberEmail", $value);
		return true;
	}
	
	public function setForename ($value) {
		$this->setData("memberForename", $value);
		return true;
	}
	
	public function setPrivileges ($value) {
		if (($value = intval($value)) !== 0) {
			$this->setData("memberPrivileges", $value);
			return true;
		} else {
			$this->setMessage(LANG_INVALID." ".strtolower(LANG_PRIVILEGES));
			return false;
		}
	}
	
	public function setSurname ($value) {
		$this->setData("memberSurname", $value);
		return true;
	}

}