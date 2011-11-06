<?php
/**
 * Subscriber object.
 *
 * @author Chris Worfolk <chris@societaspro.org
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("baseobject.php");

class Subscriber extends BaseObject {

	function __construct ($data = array()) {
		parent::__construct($data);
	}
	
	/**
	 * Return a formatted date
	 *
	 * @return Formatted date
	 */
	public function getFormattedDate () {
		return date("j F Y H:i:s", strtotime($this->getData("subscriberDate")));
	}
	
	/**
	 * Set email address
	 *
	 * @param string $value Email address
	 * @return boolean Success
	 */
	public function setEmailAddress ($value) {
	
		if (validateEmail($value) === false) {
			$this->setMessage(LANG_INVALID." ".LANG_EMAIL_ADDRESS);
			return false;
		}
		
		$this->setData("subscriberEmail", $value);
		return true;
	
	}

}