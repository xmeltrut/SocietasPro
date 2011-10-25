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
		$this->data["memberEmail"] = $value;
		return true;
	}
	
	public function setForename ($value) {
		$this->data["memberForename"] = $value;
		return true;
	}
	
	public function setSurname ($value) {
		$this->setData("memberSurname", $value);
		return true;
	}

}