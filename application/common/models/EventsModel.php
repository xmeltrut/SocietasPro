<?php
/**
 * Events model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

require_once("basemodel.php");
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
	
		$event = $this->getById($id);
		$event->unsetID();
		return $this->save($event);
	
	}
	
	/**
	 * Get a list of events
	 */
	public function get () {
	
		$events = array();
		
		$sql = "SELECT * FROM ".DB_PREFIX."events ";
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
		if (
			!$object->setName($d["name"]) ||
			!$object->setLocation($d["location"]) ||
			!$object->setDateByArray($d["date"]) ||
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