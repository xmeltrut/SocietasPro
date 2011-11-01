<?php
/**
 * Pages model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("basemodel.php");
require_once("objects/Page.php");

class PagesModel extends BaseModel {

	protected $tableName = "pages";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Create a new page
	 *
	 * @param string $name Name
	 * @param string $slug URL
	 * @param string $content Content
	 * @return boolean Success
	 */
	public function create ($name, $slug, $content) {
	
		// create object
		$page = new Page();
		
		// add data to object
		if (
			!$page->setName($name) ||
			!$page->setSlug($slug) ||
			!$page->setContent($content)
		) {
			$this->setMessage($page->getMessage());
			return false;
		}
		
		// save object
		return $this->save($page);
	
	}
	
	/**
	 * Get a list of pages
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

}
