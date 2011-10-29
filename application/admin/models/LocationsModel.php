<?php
/**
 * Locations model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("basemodel.php");
require_once("objects/event.php");

class LocationsModel extends BaseModel {

	protected $tableName = "locations";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Create a new location
	 *
	 * @param string $name Location name
	 * @return boolean Success
	 */
	public function create ($name) {
	
		
	
	}
	
	/**
	 * Get a list of locations
	 *
	 * @return array Locations
	 */
	public function get () {
	
		// initialise array
		$arr = array();
		
		// query the database
		$sql = "SELECT * FROM ".DB_PREFIX."locations ";
		$rec = $this->db->query($sql);
		
		// loop through records
		while ($row = $rec->fetch()) {
			$arr[] = new Location($row);
		}
		
		// return results
		return $arr;
	
	}

}
