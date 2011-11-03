<?php
/**
 * Event object
 *
 * @author Chris Worfolk <chris@societaspro.org
 * @package SocietasPro
 * @subpackage Common
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
		return date("j F Y H:i:s", strtotime($this->getData("eventDate")));
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
			$this->setMessage(LANG_INVALID." ".strtolower(LANG_DATE));
			return false;
		} else {
			$this->setData("eventDate", date("Y-m-d H:i:s", $unixTime));
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
	
		$this->setData("eventDescription", $description);
		return true;
	
	}
	
	/**
	 * Set the location
	 *
	 * @param int $id ID of location
	 * @return boolean
	 */
	public function setLocation ($id) {
	
		$this->setData("eventLocation", $id);
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
			$this->setMessage(LANG_INVALID." ".strtolower(LANG_NAME));
			return false;
		} else {
			$this->setData("eventName", $name);
			return true;
		}
	
	}
	
	/**
	 * Unset the ID. Used for cloning.
	 *
	 * @return boolean Success
	 */
	public function unsetID () {
		return $this->unsetData("eventID");
	}

}