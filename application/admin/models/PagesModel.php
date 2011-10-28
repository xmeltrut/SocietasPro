<?php
/**
 * Pages model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("basemodel.php");
require_once("objects/page.php");

class PagesModel extends BaseModel {

	protected $tableName = "pages";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Create a new page
	 *
	 * @param string $name Name
	 * @param string $content Content
	 * @return boolean Success
	 */
	public function create ($name, $content) {
	
		// create object
		$page = new Page();
		
		// add data to object
		if (
			!$page->setName($name) ||
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

}
