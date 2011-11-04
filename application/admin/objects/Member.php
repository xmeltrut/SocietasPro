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
	
	public function setAddress ($value) {
		$this->setData("memberAddress", $value);
		return true;
	}
	
	/**
	 * Set email address. It can be blank, but if it isn't, it must
	 * be a well formed email address.
	 *
	 * @param string $value Email address
	 * @return boolean Success
	 */
	public function setEmailAddress ($value) {
	
		if ($value != "") {
			if (validateEmail($value) === false) {
				$this->setMessage(LANG_INVALID." ".LANG_EMAIL_ADDRESS);
				return false;
			}
		}
		
		$this->setData("memberEmail", $value);
		return true;
	
	}
	
	public function setForename ($value) {
		$this->setData("memberForename", $value);
		return true;
	}
	
	public function setNotes ($value) {
		$this->setData("memberNotes", $value);
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