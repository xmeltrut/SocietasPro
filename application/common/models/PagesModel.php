<?php
/**
 * Pages model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

require_once("basemodel.php");
require_once("objects/Page.php");

class PagesModel extends BaseModel {

	protected $tableName = "pages";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Clone a page
	 *
	 * @param int $id ID
	 */
	public function cloneById ($id) {
	
		// get the page and unset it's ID
		$page = $this->getById($id);
		$page->unsetID();
		
		if ($this->save($page)) {
			$newData = json_encode(array("pageID" => $this->db->insertId()));
			auditTrail(16, $page->original(), $newData);
			$this->setMessage(LANG_SUCCESS);
			return true;
		} else {
			$this->setMessage(LANG_FAILED);
			return false;
		}
	
	}
	
	/**
	 * Get a list of pages
	 *
	 * @param int $parentID Page ID, used for recursion
	 * @param int $layer Count of the layers we've recursed into
	 * @return array Array of Pages objects
	 */
	public function get ($parentID = 0, $layer = 0) {
	
		// initialse an array
		$arr = array();
		
		// query the database
		$sql = "SELECT * FROM ".DB_PREFIX."pages
				WHERE pageParent = " . $parentID;
		$rec = $this->db->query($sql);
		
		// loop through results
		while ($row = $rec->fetch()) {
	
			$prefix = str_repeat("-- ", $layer);
			$pageObject = new Page($row);
			$pageObject->setName($prefix.$row["pageName"]);
			$arr[] = $pageObject;
			
			$children = $this->get($row["pageID"], ($layer+1));
			$arr = array_merge($arr, $children);
		
		}
		
		// return array
		return $arr;
	
	}
	
	/**
	 * Get a list of pages as an array
	 *
	 * @param int $excludedID If you want to exclude a page, pass its ID
	 * @param int $parentID Page ID, used for recursion
	 * @param int $layer Count of the layers we've recursed into
	 * @return array Associative array of pages
	 */
	public function getAsArray ($excludedID = 0, $parentID = 0, $layer = 0) {
	
		// initialise an array
		$arr = array();
		
		// query the database
		$sql = "SELECT * FROM ".DB_PREFIX."pages
				WHERE pageParent = ".$parentID."
				AND pageID != ".$excludedID;
		$rec = $this->db->query($sql);
		
		// loop through results
		while ($row = $rec->fetch()) {
			$prefix = str_repeat("-- ", $layer);
			$arr[$row["pageID"]] = $prefix.$row["pageName"];
			$children = $this->getAsArray($excludedID, $row["pageID"], ($layer+1));
			$arr += $children;
		}
		
		// return array
		return $arr;
	
	}
	
	/**
	 * Get a specific page
	 *
	 * @param int $id Page ID
	 * @return Page
	 */
	public function getById ($id) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."pages WHERE pageID = " . intval($id);
		$rec = $this->db->query($sql);
		
		if ($row = $rec->fetch()) {
			return new Page($row);
		} else {
			return false;
		}
	
	}
	
	/**
	 * Get an array of child page IDs
	 *
	 * @param int $id Page ID
	 * @return array Array of page IDs
	 */
	public function getChildrenAsArray ($id) {
	
		// initialise an array
		$arr = array();
		
		// query database
		$sql = "SELECT pageID FROM ".DB_PREFIX."pages WHERE pageParent = ".$id;
		$rec = $this->db->query($sql);
		
		// loop through results
		while ($row = $rec->fetch()) {
			$arr[] = $row["pageID"];
			$children = $this->getChildrenAsArray($row["pageID"]);
			$arr = array_merge($arr, $children);
		}
		
		// return results
		return $arr;
	
	}
	
	/**
	 * Check a slug is unique and if not, generate a new one
	 *
	 * @param string $slug Slug
	 * @param int $id ID of current page
	 * @param int $parent ID of parent page
	 * @return string Unique slug
	 */
	public function validateSlug ($slug, $id = 0, $parent = 0) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."pages
				WHERE pageSlug = '".escape($slug)."'
				AND pageID != " . $id . "
				AND pageParent = " . $parent;
		$rec = $this->db->query($sql);
		
		if ($rec->getRows() == 0) {
			return $slug;
		} else {
			return $this->validateSlug(strIncrement($slug));
		}
	
	}
	
	/**
	 * Edit or create a page
	 *
	 * @param array $d Data
	 * @param int $id ID or false if creating
	 * @return boolean Success
	 */
	public function write ($d, $id = false) {
	
		// get object
		if ($id) {
			$object = $this->getById($id);
			$auditAction = 10;
		} else {
			$object = new Page();
			$auditAction = 9;
		}
		
		// Make modifications. We must set the parent before the slug for validation reasons.
		if (
			!$object->setParent($d["parent"]) ||
			!$object->setName($d["name"]) ||
			!$object->setSlug($d["slug"]) ||
			!$object->setContent($d["content"])
		) {
			$this->setMessage($object->getMessage());
			return false;
		}
		
		// record in audit trail
		auditTrail($auditAction, $object->original(), $object);
		
		// save object
		$this->setMessage(LANG_SUCCESS);
		return $this->save($object);
	
	}

}
