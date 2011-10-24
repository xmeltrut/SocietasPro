<?php
/**
 * Base model for models to extend from.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

abstract class BaseModel {

	/**
	 * Variable to hold database connection.
	 */
	protected $db;
	
	/**
	 * Constructor
	 */
	function __construct () {
	
		require_once("database.php");
		$this->db = Database::getInstance();
	
	}
	
	/**
	 * Generic save function. Needs overriding.
	 *
	 * @param object $obj Object to save
	 * @return boolean
	 */
	public function save ($obj) {
	
		// check we have a table name defined
		if (!isset($this->tableName)) {
			return false;
		}
		
		// get data from object
		$data = $obj->getAllData();
		
		// remove the identifier
		$idKey = substr($this->tableName, 0, -1)."ID";
		if (!isset($data[$idKey])) {
			return false;
		} else {
			$identifier = $data[$idKey];
			unset($data[$idKey]);
		}
		
		// build the SQL
		$sql = "UPDATE ".DB_PREFIX.$this->tableName." SET ";
		$updateSql = "";
		
		foreach ($data as $key => $val) {
			$updateSql .= "$key = '".escape($val)."', ";
		}
		
		$sql .= substr($updateSql, 0, -2) . " ";
		$sql .= "WHERE $idKey = $identifier ";
		
		$rv = $this->db->query($sql);
		return true;
	
	}

}
