<?php
/**
 * Events model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

require_once("objects/event.php");

class EventsModel extends BaseModel {

	protected $tableName = "events";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Clone an event
	 *
	 * @param int $id ID
	 */
	public function cloneById ($id) {
	
		// create and object and strip the ID
		$event = $this->getById($id);
		$event->unsetID();
		
		if ($this->save($event)) {
			$newData = json_encode(array("eventID" => $this->db->insertId()));
			auditTrail(15, $event->original(), $newData);
			$this->setMessage(LANG_SUCCESS);
			return true;
		} else {
			$this->setMessage(LANG_FAILED);
			return false;
		}
	
	}
	
	/**
	 * Count the number of events
	 *
	 * @return int Number of events
	 */
	public function count () {
	
		$sql = "SELECT COUNT(eventID) FROM ".DB_PREFIX."events ";
		return $this->db->fetchOne($sql);
	
	}
	
	/**
	 * Get a list of events
	 *
	 * @param int $pageNum Page number
	 * @return array Array of events
	 */
	public function get ($pageNum = 1) {
	
		$events = array();
		
		$sql = "SELECT * FROM ".DB_PREFIX."events ".sqlLimit($pageNum);
		$rec = $this->db->query($sql);
		
		while ($row = $rec->fetch()) {
			$events[] = new Event($row);
		}
		
		return $events;
	
	}
	
	/**
	 * Get a specific event
	 *
	 * @param int $id Event ID
	 * @return Event
	 */
	public function getById ($id) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."events WHERE eventID = " . intval($id);
		$rec = $this->db->query($sql);
		
		if ($row = $rec->fetch()) {
			return new Event($row);
		} else {
			return false;
		}
	
	}
	
	/**
	 * Edit or create an event
	 *
	 * @param array $d Data
	 * @param int $id ID or false if creating
	 * @return boolean Success
	 */
	public function write ($d, $id = false) {
	
		// get object
		if ($id) {
			$object = $this->getById($id);
			$auditAction = 8;
		} else {
			$object = new Event();
			$auditAction = 7;
		}
		
		// make modifications
		$writes = array (
			$object->setName($d["name"]),
			$object->setLocation($d["location"]),
			$object->setDateByArray($d["date"]),
			$object->setDescription($d["description"])
		);
		
		if (in_array(false, $writes)) {
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