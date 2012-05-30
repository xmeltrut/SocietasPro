<?php
/**
 * Events model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

namespace Model;

use Framework\Abstracts\BaseModel;
use Framework\Interfaces\iModel;
use Framework\Utilities\Pagination;
use Framework\Logging\AuditTrail;

class EventsModel extends BaseModel implements iModel {

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
			$newData = json_encode(array("eventID" => $this->db->lastInsertId()));
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
		
		$sql = "SELECT * FROM ".DB_PREFIX."events ORDER BY eventDate DESC ".Pagination::sqlLimit($pageNum);
		$rec = $this->db->query($sql);
		
		while ($row = $rec->fetch()) {
			$events[] = new Event($row);
		}
		
		return $events;
	
	}
	
	/**
	 * Get a list of events for a specific date
	 *
	 * @param string $date Date in a YYYYMMDD format
	 * @return array Array of events
	 */
	public function getByDate ($date) {
	
		// initialise variables
		$events = array();
		$searchDate = substr($date,0,4)."-".substr($date,4,2)."-".substr($date,6,2);
		
		// query database
		$sql = "SELECT * FROM ".DB_PREFIX."events
				WHERE eventDate LIKE '".$searchDate."%'
				ORDER BY eventDate ASC";
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
			if ($id === false) { return false; }
		}
		
		if ($object->hasChanged()) {
			if ($this->save($object)) {
				AuditTrail::log($auditAction, $object->original(), $object);
				$this->setMessage(LANG_SUCCESS);
				return true;
			}
		}
		
		return false;
	
	}

}