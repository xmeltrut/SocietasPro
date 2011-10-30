<?php
/**
 * Locations model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("basemodel.php");
require_once("objects/location.php");

class LocationsModel extends BaseModel {

	protected $tableName = "locations";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Create a new location
	 *
	 * @param string $name Location name
	 * @param string $description Description
	 * @return boolean Success
	 */
	public function create ($name, $description) {
	
		// create an object
		$location = new Location();
		
		// add data to object
		if (
			!$location->setName($name) ||
			!$location->setDescription($description)
		) {
			$this->setMessage($location->getMessage());
			return false;
		}
		
		// save object
		return $this->save($location);
	
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
