<?php
/**
 * Pages model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 *
 * @todo validateSlug() needs to exclude the current page
 * @todo Slug should be automatically generated via JavaScript
 * @todo Implement new write() method
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
	
		$page = $this->getById($id);
		$page->unsetID();
		return $this->save($page);
	
	}
	
	/**
	 * Get a list of pages
	 *
	 * @return array Array of Pages objects
	 */
	public function get () {
	
		$arr = array();
		
		$sql = "SELECT * FROM ".DB_PREFIX."pages WHERE pageParent = 0 ";
		$rec = $this->db->query($sql);
		
		while ($row = $rec->fetch()) {
			$arr[] = new Page($row);
		}
		
		return $arr;
	
	}
	
	/**
	 * Get a list of pages as an array
	 *
	 * @return array Associative array of pages
	 */
	public function getAsArray () {
	
		$arr = array();
		
		$sql = "SELECT * FROM ".DB_PREFIX."pages WHERE pageParent = 0 ";
		$rec = $this->db->query($sql);
		
		while ($row = $rec->fetch()) {
			$arr[$row["pageID"]] = $row["pageName"];
		}
		
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
	 * Check a slug is unique and if not, generate a new one
	 *
	 * @param string $slug Slug
	 * @return string Unique slug
	 */
	public function validateSlug ($slug) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."pages WHERE pageSlug = '".escape($slug)."' ";
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
		
		// make modifications
		if (
			!$object->setName($d["name"]) ||
			!$object->setSlug($d["slug"]) ||
			!$object->setParent($d["parent"]) ||
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
