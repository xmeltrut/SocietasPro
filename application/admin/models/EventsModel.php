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

	protected $tableName = "members";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Create a new event
	 */
	public function create ($name, &$msg) {
	
		// validation
		if ($name == "") {
			$msg = "You did not enter a name.";
			return false;
		}
		
		// database query
		$sql = "INSERT INTO ".DB_PREFIX."events (
				eventName
				) VALUES (
				'".escape($name)."'
				)";
		$this->db->query($sql);
	
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