<?php
/**
 * Members groups model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

namespace Model;

use Framework\Abstracts\BaseModel;
use Framework\Interfaces\iModel;
use Framework\Logging\AuditTrail;

class MembersGroupsModel extends BaseModel implements iModel {

	protected $tableName = "members_groups";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Get members groups
	 *
	 * @return array Fields
	 */
	public function get () {
	
		$arr = array();
		
		$sql = "SELECT * FROM ".DB_PREFIX."members_groups ";
		$rec = $this->db->query($sql);
		
		while ($row = $rec->fetch()) {
			$arr[] = new MembersGroup($row);
		}
		
		return $arr;
	
	}
	
	/**
	 * Get a specific group
	 *
	 * @param int $id Group ID
	 * @return MembersGroup
	 */
	public function getById ($id) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."members_groups WHERE groupID = " . $id;
		$rec = $this->db->query($sql);
		
		if ($row = $rec->fetch()) {
			return new MembersGroup($row);
		} else {
			return false;
		}
	
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
			$auditAction = 27;
		} else {
			$object = new MembersGroup();
			$auditAction = 26;
		}
		
		// make modifications
		$writes = array (
			$object->setName($d["name"])
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
