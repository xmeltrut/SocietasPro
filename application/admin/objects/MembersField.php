<?php
/**
 * Members field is an object to represent a custom database column
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("baseobject.php");

class MembersFieldPost extends BaseObject {

	function __construct ($data = array()) {
		parent::__construct($data);
	}
	
	/**
	 * Set the name of the field
	 *
	 * @param string $value Name
	 * @return boolean Success
	 */
	public function setName ($value) {
		if ($value == "") {
			$this->setMessage(LANG_INVALID." ".strtolower(LANG_NAME));
			return false;
		} else {
			$this->setData("postName", $value);
			return true;
		}
	}

}
