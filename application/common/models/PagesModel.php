<?php
/**
 * Pages model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

require_once("objects/Page.php");

class PagesModel extends BaseModel implements iModel {

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
			$newData = json_encode(array("pageID" => $this->db->lastInsertId()));
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
		$rowCount = 1;
		
		// query the database
		$sql = "SELECT * FROM ".DB_PREFIX."pages
				WHERE pageParent = " . $parentID."
				ORDER BY pageOrder ASC, pageName ASC ";
		$rec = $this->db->query($sql);
		
		// loop through results
		while ($row = $rec->fetch()) {
	
			$prefix = str_repeat("-- ", $layer);
			$pageObject = new Page($row);
			$pageObject->setName($prefix.$row["pageName"]);
			
			if ($rowCount == 1) {
				$pageObject->setCanMoveUp(false);
			}
			
			if ($rowCount == $rec->rowCount()) {
				$pageObject->setCanMoveDown(false);
			}
			
			$arr[] = $pageObject;
			
			$children = $this->get($row["pageID"], ($layer+1));
			$arr = array_merge($arr, $children);
			
			$rowCount++;
		
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
				AND pageID != ".$excludedID."
				ORDER BY pageOrder ASC, pageName ASC ";
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
	 * Get a specific page by slug
	 *
	 * @param string $slug Page slug
	 * @return Page
	 */
	public function getBySlug ($slug) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."pages WHERE pageSlug = ? ";
		$rec = $this->db->prepare($sql);
		$rec->execute(array($slug));
		
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
	 * Get the default page for the public site
	 *
	 * @return Page Homepage
	 */
	public function getHomepage () {
	
		// query for page ID
		$sql = "SELECT pageID FROM ".DB_PREFIX."pages
				WHERE pageParent = 0
				ORDER BY pageOrder ASC, pageName ASC
				LIMIT 0, 1 ";
		$id  = $this->db->fetchOne($sql);
		
		// deliver page
		return $this->getById($id);
	
	}
	
	/**
	 * Work out the next incrementing page order
	 *
	 * @param int $parent Page parent ID
	 * @return int Order
	 */
	private function getNextOrder ($parent) {
	
		// build SQL
		$sql = "SELECT pageOrder FROM ".DB_PREFIX."pages
				WHERE pageParent = ".intval($parent)."
				ORDER BY pageOrder DESC LIMIT 0, 1 ";
		
		// return number
		$order = $this->db->fetchOne($sql);
		
		if ($order !== false) {
			return ($order + 2);
		} else {
			return 0;
		}
	
	}
	
	/**
	 * Move a page down
	 *
	 * @param int $id Page ID
	 * @return boolean Success
	 */
	public function moveDown ($id) {
	
		$sql = "UPDATE ".DB_PREFIX."pages SET pageOrder = (pageOrder + 3) WHERE pageID = " . $id;
		return $this->db->query($sql);
		
		$this->reorder();
	
	}
	
	/**
	 * Move a page up
	 *
	 * @param int $id Page ID
	 * @return boolean Success
	 */
	public function moveUp ($id) {
	
		$sql = "UPDATE ".DB_PREFIX."pages SET pageOrder = (pageOrder - 3) WHERE pageID = " . $id;
		if ($this->db->query($sql)) {
			$this->reorder();
			return true;
		} else {
			return false;
		}
	
	}
	
	/**
	 * Renumber the paging orders
	 *
	 * @param int $parent Parent page ID, or false to do all of them
	 */
	private function reorder ($parent = false) {
	
		if ($parent === false) {
		
			// get all potential parent IDs
			$sql = "SELECT DISTINCT(pageParent) FROM ".DB_PREFIX."pages ";
			$rec = $this->db->query($sql);
			
			// loop though each one
			while ($row = $rec->fetch()) {
				$this->reorder($row["pageParent"]);
			}
		
		} else {
	
			// initialise variables
			$orderNumber = 0;
			
			// get a list of pages
			$sql = "SELECT * FROM ".DB_PREFIX."pages
					WHERE pageParent = " . $parent . "
					ORDER BY pageOrder ASC, pageName ASC ";
			$rec = $this->db->query($sql);
			
			// loop through pages
			while ($row = $rec->fetch()) {
			
				// run the query
				$sql = "UPDATE ".DB_PREFIX."pages
						SET pageOrder = " . $orderNumber . "
						WHERE pageID = " . $row["pageID"];
				$this->db->query($sql);
				
				// increment the number
				$orderNumber += 2;
			
			}
		
		}
	
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
				WHERE pageSlug = ?
				AND pageID != ?
				AND pageParent = ? ";
		$rec = $this->db->prepare($sql);
		$rec->execute(array($slug, $id, $parent));
		
		if ($rec->rowCount() == 0) {
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
		$writes = array (
			$object->setParent($d["parent"]),
			$object->setName($d["name"]),
			$object->setSlug($d["slug"]),
			$object->setContent($d["content"])
		);
		
		// adjust the page order
		if (!$id) {
			$object->setOrder($this->getNextOrder($object->pageParent));
		} else {
			if ($object->hasChanged("pageParent")) {
				$object->setOrder($this->getNextOrder($object->pageParent));
			}
		}
		
		if (in_array(false, $writes)) {
			$this->setMessage($object->getMessage());
			if ($id === false) { return false; }
		}
		
		if ($object->hasChanged()) {
			if ($this->save($object)) {
				auditTrail($auditAction, $object->original(), $object);
				$this->setMessage(LANG_SUCCESS);
				return true;
			}
		}
		
		return false;
	
	}

}
