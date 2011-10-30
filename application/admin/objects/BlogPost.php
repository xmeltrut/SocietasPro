<?php
/**
 * Blog post object
 *
 * @author Chris Worfolk <chris@societaspro.org
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("baseobject.php");

class BlogPost extends BaseObject {

	function __construct ($data = array()) {
		parent::__construct($data);
	}
	
	/**
	 * Return a formatted date
	 *
	 * @return Formatted date
	 */
	public function getFormattedDate () {
		return date("j F Y H:i:s", strtotime($this->getData("postDate")));
	}
	
	public function setContent ($value) {
		$this->setData("postContent", $value);
		return true;
	}
	
	/**
	 * Set the date of a post
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
			$this->setData("postDate", date("Y-m-d H:i:s", $unixTime));
			return true;
		}
	
	}
	
	public function setName ($value) {
		if ($value == "") {
			$this->setMessage(LANG_INVALID." ".strtolower(LANG_NAME));
			return false;
		} else {
			$this->setData("postName", $value);
			return true;
		}
	}

}
