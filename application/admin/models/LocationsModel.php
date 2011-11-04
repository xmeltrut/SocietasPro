<?php
/**
 * Locations model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo There are no edit or delete functions for this controller
 */

require_once("basemodel.php");
require_once("objects/location.php");

class LocationsModel extends BaseModel {

	protected $tableName = "locations";
	
	function __construct () {
		parent::__construct();
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
	
	/**
	 * Edit or create a location
	 *
	 * @param array $d Data
	 * @param int $id ID or false if creating
	 * @return boolean Success
	 */
	public function write ($d, $id = false) {
	
		// get object
		if ($id) {
			$object = $this->getById($id);
			$auditAction = 4;
		} else {
			$object = new Location();
			$auditAction = 3;
		}
		
		// make modifications
		if (
			!$object->setName($d["name"]) ||
			!$object->setDescription($d["description"])
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
