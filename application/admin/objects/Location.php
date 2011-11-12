<?php
/**
 * Location object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

class Location extends BaseObject {

	function __construct ($data = array()) {
		parent::__construct($data);
	}
	
	/**
	 * Set the description
	 *
	 * @param string $description Description of the location
	 * @return boolean
	 */
	public function setDescription ($description) {
	
		$this->setData("locationDescription", $description);
		return true;
	
	}
	
	/**
	 * Set the name of the object
	 *
	 * @param string $name Name of location
	 * @return boolean
	 */
	public function setName ($name) {
	
		if ($name == "") {
			$this->setMessage(LANG_INVALID." ".strtolower(LANG_NAME));
			return false;
		} else {
			$this->setData("locationName", $name);
			return true;
		}
	
	}

}
