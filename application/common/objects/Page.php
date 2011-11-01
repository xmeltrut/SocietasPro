<?php
/**
 * Page object
 *
 * @author Chris Worfolk <chris@societaspro.org
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Require slugs to be unique
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
			$this->setMessage(LANG_INVALID." ".strtolower(LANG_NAME));
			return false;
		} else {
			$this->setData("pageName", $value);
			return true;
		}
	}
	
	public function setSlug ($value) {
		if ($value == "") {
			$this->setMessage(LANG_INVALID." ".LANG_URL);
			return false;
		} else {
			$this->setData("pageSlug", $value);
			return true;
		}
	}

}
