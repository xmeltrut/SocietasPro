<?php
/**
 * Members group object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

namespace Model;

use Framework\Abstracts\BaseObject;

class MembersGroup extends BaseObject {

	function __construct ($data = array()) {
		parent::__construct($data);
	}
	
	/**
	 * Set the name of the group
	 *
	 * @param string $value Name
	 * @return boolean Success
	 */
	public function setName ($value) {
		if ($value == "") {
			$this->setMessage(LANG_INVALID." ".strtolower(LANG_NAME));
			return false;
		} else {
			$this->setData("groupName", $value);
			return true;
		}
	}

}
