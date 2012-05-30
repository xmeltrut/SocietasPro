<?php
/**
 * Blog post object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

namespace Model;

use Framework\Abstracts\BaseObject;

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
		return date("j F Y H:i:s", strtotime($this->postDate));
	}
	
	/**
	 * Set the content of the post
	 *
	 * @param string $value Value
	 * @return boolean Success
	 */
	public function setContent ($value) {
		$this->setData("postContent", strPurify($value));
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
	
	public function setSlug ($value) {
	
		// check for a value
		if ($value == "") {
			$this->setMessage(LANG_INVALID." ".LANG_URL);
			return false;
		} else {
			$id = ($this->postID) ? $this->postID : 0;
			$postsModel = new BlogPostsModel();
			$this->setData("postSlug", $postsModel->validateSlug($value, $id));
			return true;
		}
	}
	
	/**
	 * Set the status of the page
	 *
	 * @param string $value Value to set to
	 * @return boolean Success
	 */
	public function setStatus ($value) {
		$vals = array("Published", "Draft");
		if (in_array($value, $vals)) {
			$this->setData("postStatus", $value);
			return true;
		} else {
			$this->setMessage(LANG_INVALID." ".LANG_STATUS);
			return false;
		}
	}

}
