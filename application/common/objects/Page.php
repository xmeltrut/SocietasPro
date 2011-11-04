<?php
/**
 * Page object
 *
 * @author Chris Worfolk <chris@societaspro.org
 * @package SocietasPro
 * @subpackage Common
 *
 * @todo setParent() functions needs to do some validation
 */

require_once("baseobject.php");

class Page extends BaseObject {

	function __construct ($data = array()) {
		parent::__construct($data);
	}
	
	/**
	 * Set page content
	 *
	 * @param string $value Page content
	 * @return boolean Success
	 */
	public function setContent ($value) {
		$this->setData("pageContent", $value);
		return true;
	}
	
	/**
	 * Set the name of the page
	 *
	 * @param string $value Page name
	 * @return boolean Success
	 */
	public function setName ($value) {
		if ($value == "") {
			$this->setMessage(LANG_INVALID." ".strtolower(LANG_NAME));
			return false;
		} else {
			$this->setData("pageName", $value);
			return true;
		}
	}
	
	/**
	 * Set the parent page
	 *
	 * @param int $value Parent ID
	 * @return boolean Success
	 */
	public function setParent ($value) {
	
		$this->setData("pageParent", intval($value));
		return true;
	
	}
	
	/**
	 * Set the slug of a page
	 *
	 * @param string $value Value to set to
	 * @retun boolean Success
	 */
	public function setSlug ($value) {
	
		// check for a value
		if ($value == "") {
			$this->setMessage(LANG_INVALID." ".LANG_URL);
			return false;
		} else {
			$pageModel = new PagesModel();
			$this->setData("pageSlug", $pageModel->validateSlug($value));
			return true;
		}
	}
	
	/**
	 * Unset the ID. Used for cloning.
	 *
	 * @return boolean Success
	 */
	public function unsetID () {
		return $this->unsetData("pageID");
	}

}
