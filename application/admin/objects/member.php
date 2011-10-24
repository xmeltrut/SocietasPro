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

	function __construct ($data) {
		parent::__construct($data);
	}
	
	public function setEmailAddress ($value) {
		$this->data["memberEmail"] = $value;
	}
	
	public function setForename ($value) {
		$this->data["memberForename"] = $value;
	}
	
	public function setSurname ($value) {
		$this->setData("memberSurname", $value);
	}

}