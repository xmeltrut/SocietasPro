<?php
/**
 * Page object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

class Page extends BaseObject {

	/**
	 * Object specific instance variables
	 */
	private $canMoveUp = true;
	private $canMoveDown = true;
	
	/**
	 * Call parent constructor
	 */
	function __construct ($data = array()) {
		parent::__construct($data);
	}
	
	/**
	 * Getter for can move down
	 *
	 * @return boolean
	 */
	public function canMoveDown () {
		return $this->canMoveDown;
	}
	
	/**
	 * Getter for can move up
	 *
	 * @return bolean
	 */
	public function canMoveUp () {
		return $this->canMoveUp;
	}
	
	/**
	 * Set whether a page can be moved down
	 *
	 * @param boolean $value
	 * @return boolean Success
	 */
	public function setCanMoveDown ($value) {
		if (is_bool($value)) {
			$this->canMoveDown = $value;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Set whether a page can be moved up
	 *
	 * @param boolean $value
	 * @return boolean Success
	 */
	public function setCanMoveUp ($value) {
		if (is_bool($value)) {
			$this->canMoveUp = $value;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Set page content
	 *
	 * @param string $value Page content
	 * @return boolean Success
	 */
	public function setContent ($value) {
		$this->setData("pageContent", strPurify($value));
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
	 * Set the order
	 *
	 * @param int $value Order
	 * @return boolean
	 */
	public function setOrder ($value) {
	
		if (is_int($value)) {
			$this->setData("pageOrder", $value);
			return true;
		} else {
			return false;
		}
	
	}
	
	/**
	 * Set the parent page
	 *
	 * @param int $value Parent ID
	 * @return boolean Success
	 */
	public function setParent ($value) {
	
		// validation
		if ($this->pageID) {
		
			// check IDs aren't identical
			if ($this->pageID == $value) {
				$this->setMessage(strFirst(LANG_INVALID." ".LANG_PARENT));
				return false;
			}
			
			// check this parent isn't a child of this page
			$pagesModel = new PagesModel();
			$ids = $pagesModel->getChildrenAsArray($this->pageID);
			
			if (in_array($value, $ids)) {
				$this->setMessage(strFirst(LANG_INVALID." ".LANG_PARENT));
				return false;
			}
		
		}
		
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
			$id = ($this->pageID) ? $this->pageID : 0;
			$parent = ($this->pageParent) ? $this->pageParent : 0;
			$pageModel = new PagesModel();
			$this->setData("pageSlug", $pageModel->validateSlug($value, $id, $parent));
			return true;
		}
	}
	
	/**
	 * Set the status of the page
	 *
	 * @param string $value Value to set to
	 * @return boolean Success
	 */
	public function setStatus ($value) {
		$vals = array("Published", "Draft");
		if (in_array($value, $vals)) {
			$this->setData("pageStatus", $value);
			return true;
		} else {
			$this->setMessage(LANG_INVALID." ".LANG_STATUS);
			return false;
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
