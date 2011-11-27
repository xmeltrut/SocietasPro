<?php
/**
 * Event object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

class Event extends BaseObject {

	public $location = false;
	
	/**
	 * Constructor. Run parent and location data gathering.
	 *
	 * @param array Data
	 */
	function __construct ($data = array()) {
	
		parent::__construct($data);
		$this->fetchLocationData();
	
	}
	
	/**
	 * Fetch the location details
	 *
	 * @return boolean Success
	 */
	private function fetchLocationData() {
	
		if ($this->eventLocation) {
			require_once("models/LocationsModel.php");
			$locationsModel = new LocationsModel();
			$this->location = $locationsModel->getById($this->eventLocation);
			return true;
		}
				
		$this->location = false;
		return true;
	
	}
	
	/**
	 * Return a formatted date
	 *
	 * @return Formatted date
	 */
	public function getFormattedDate () {
		return date("j F Y H:i:s", strtotime($this->eventDate));
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
		$this->fetchLocationData();
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