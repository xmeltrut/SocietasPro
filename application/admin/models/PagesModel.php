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
	 * Get a list of pages
	 */
	public function get () {
	
		$arr = array();
		
		$sql = "SELECT * FROM ".DB_PREFIX."pages WHERE pageParent = 0 ";
		$rec = $this->db->execute($sql);
		
		while ($row = $rec->fetch()) {
			$arr[] = new Page($row);
		}
		
		return $arr;
	
	}

}
