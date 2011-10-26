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
	
	public function setEmail ($value) {
		$this->data["subscriberEmail"] = $value;
		return true;
	}

}