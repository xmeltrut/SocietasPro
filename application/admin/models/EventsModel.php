<?php
/**
 * Events model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("basemodel.php");
require_once("objects/event.php");

class EventsModel extends BaseModel {

	protected $tableName = "events";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Create a new event
	 *
	 * @param string $name Name of event
	 * @param array Array of date elements
	 */
	public function create ($name, $date) {
	
		// create object
		$event = new Event();
		
		// add data to object
		if (
			!$event->setName($name) ||
			!$event->setDateByArray($date)
		) {
			$this->setMessage($event->getMessage());
			return false;
		}
		
		// save object
		return $this->save($event);
	
	}
	
	/**
	 * Get a list of events
	 */
	public function getEvents () {
	
		$events = array();
		
		$sql = "SELECT * FROM ".DB_PREFIX."events ";
		$rec = $this->db->query($sql);
		
		while ($row = $rec->fetch()) {
			$events[] = new Event($row);
		}
		
		return $events;
	
	}

}