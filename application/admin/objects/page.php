<?php
/**
 * Page object
 *
 * @author Chris Worfolk <chris@societaspro.org
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("baseobject.php");

class Page extends BaseObject {

	function __construct ($data = array()) {
		parent::__construct($data);
	}
	
	public function setContent ($value) {
		$this->setData("pageContent", $value);
		return true;
	}
	
	public function setName ($value) {
		if ($value == "") {
			$this->setMessage("You did not enter a name.");
			return false;
		} else {
			$this->setData("pageName", $value);
			return true;
		}
	}

}
