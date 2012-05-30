<?php
/**
 * Members custom fields model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

namespace Model;

use Framework\Abstracts\BaseModel;
use Framework\Interfaces\iModel;

class MembersFieldsModel extends BaseModel implements iModel {

	protected $tableName = "members_fields";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Get members fields
	 *
	 * @return array Fields
	 */
	public function get () {
	
		$arr = array();
		
		$sql = "SELECT * FROM ".DB_PREFIX."members_fields ";
		$rec = $this->db->query($sql);
		
		while ($row = $rec->fetch()) {
			$arr[] = new MembersField($row);
		}
		
		return $arr;
	
	}
	
	/**
	 * Get a list of fields as an array
	 *
	 * @return array Associative array containing IDs and values
	 */
	public function getAsArray () {
	
		$arr = array();
		
		$sql = "SELECT * FROM ".DB_PREFIX."members_fields ";
		$rec = $this->db->query($sql);
		
		while ($row = $rec->fetch()) {
			$arr[$row["fieldID"]] = $row["fieldName"];
		}
		
		return $arr;
	
	}
	
	/**
	 * Get a specific field
	 *
	 * @param int $id Field ID
	 * @return MembersField
	 */
	public function getById ($id) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."members_fields WHERE fieldID = " . $id;
		$rec = $this->db->query($sql);
		
		if ($row = $rec->fetch()) {
			return new MembersField($row);
		} else {
			return false;
		}
	
	}
	
	/**
	 * Return an array of the possible form types
	 *
	 * @return array Types
	 */
	public function getTypes () {
	
		$arr = array (
			"input" => LANG_TEXT,
			"textarea" => LANG_TEXTAREA,
			"select" => LANG_SELECT
		);
		
		return $arr;
	
	}
	
	/**
	 * Edit or create a field
	 *
	 * @param array $d Data
	 * @param int $id ID or false if creating
	 * @return boolean Success
	 */
	public function write ($d, $id = false) {
	
		// get object
		if ($id) {
			$object = $this->getById($id);
			$auditAction = 24;
		} else {
			$object = new MembersField();
			$auditAction = 23;
		}
		
		// make modifications
		$writes = array (
			$object->setName($d["name"]),
			$object->setType($d["type"]),
			$object->setOptions($d["options"])
		);
		
		if (in_array(false, $writes)) {
			$this->setMessage($object->getMessage());
			if ($id === false) { return false; }
		}
		
		if ($object->hasChanged()) {
			if ($this->save($object)) {
				auditTrail($auditAction, $object->original(), $object);
				$this->setMessage(LANG_SUCCESS);
				return true;
			}
		}
		
		return false;
	
	}

}
