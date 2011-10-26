<?php
/**
 * Event object
 *
 * @author Chris Worfolk <chris@societaspro.org
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("baseobject.php");

class Event extends BaseObject {

	function __construct ($data = array()) {
		parent::__construct($data);
	}
	
	/**
	 * Return a formatted date
	 *
	 * @return Formatted date
	 */
	public function getFormattedDate () {
		return date("j F Y H:i:s", strtotime($this->data["eventDate"]));
	}
	
	/**
	 * Set the date of the event
	 *
	 * @param $date Associative array of date elements
	 * @return boolean
	 */
	public function setDateByArray ($date) {
	
		$dateString  = $date["day"]." ".date("F",mktime(0,0,0,$date["month"],1))." ".$date["year"]." ";
		$dateString .= $date["hour"].":".$date["minute"].":".$date["second"];
		$unixTime = strtotime($dateString);
		
		if ($unixTime == false || $unixTime == -1) {
			$this->setMessage("Invalid date.");
			return false;
		} else {
			$this->data["eventDate"] = date("Y-m-d H:i:s", $unixTime);
			return true;
		}
	
	}
	
	/**
	 * Set the description
	 *
	 * @param string $description Description of the event
	 * @return boolean
	 */
	public function setDescription ($description) {
	
		$this->data["eventDescription"] = $description;
		return true;
	
	}
	
	/**
	 * Set the name of the object
	 *
	 * @param string $name Name of event
	 * @return boolean
	 */
	public function setName ($name) {
	
		if ($name == "") {
			$this->setMessage("You did not enter a name.");
			return false;
		} else {
			$this->data["eventName"] = $name;
			return true;
		}
	
	}

}