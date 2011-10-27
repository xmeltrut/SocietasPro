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
	 * Variable to hold standard return message
	 */
	private $message;
	
	/**
	 * Constructor
	 */
	function __construct () {
	
		require_once("database.php");
		$this->db = Database::getInstance();
	
	}
	
	/**
	 * Delete an object in this table by it's ID
	 *
	 * @param int ID
	 * @return boolean
	 */
	public function deleteById ($id) {
	
		// build the identifier
		if (!$idKey = $this->getIdentifier()) {
			return false;
		}
		
		// build the SQL
		$sql = "DELETE FROM ".DB_PREFIX.$this->tableName." WHERE " . $this->getIdentifier() . " = " . intval($id);
		return $this->db->query($sql);
	
	}
	
	/**
	 * Calculate the identifier column
	 *
	 * @return string ID column name
	 */
	protected function getIdentifier () {
	
		if (!isset($this->tableName)) {
			return false;
		}
		
		return substr($this->tableName, 0, -1)."ID";
	
	}
	
	/**
	 * Get the return message
	 *
	 * @return string Message
	 */
	public function getMessage () {
		return $this->message;
	}
	
	/**
	 * Generic save function. Needs overriding.
	 *
	 * @param object $obj Object to save
	 * @return boolean
	 */
	public function save ($obj) {
	
		// build the identifier
		if (!$idKey = $this->getIdentifier()) {
			return false;
		}
		
		// get data from object
		$data = $obj->getAllData();
		
		// is it set already?
		if (!isset($data[$idKey])) {
		
			// build arrays to implode
			$keys = array();
			$vals = array();
			
			foreach ($data as $key => $val) {
				$keys[] = $key;
				$vals[] = escape($val);
			}
			
			// this is an insert
			$sql = "INSERT INTO ".DB_PREFIX.$this->tableName." (".implode($keys, ",").") VALUES ('".implode($vals, "','")."')";
			$rv  = $this->db->query($sql);
			
		
		} else {
		
			// this is an update
			$identifier = $data[$idKey];
			unset($data[$idKey]);
			
			$sql = "UPDATE ".DB_PREFIX.$this->tableName." SET ";
			$updateSql = "";
			
			foreach ($data as $key => $val) {
				$updateSql .= "$key = '".escape($val)."', ";
			}
			
			$sql .= substr($updateSql, 0, -2) . " ";
			$sql .= "WHERE $idKey = " . $identifier;
			
			$rv = $this->db->query($sql);
		
		}
		
		// return result
		return $rv;
	
	}
	
	/**
	 * Set a return message
	 *
	 * @param string $msg Mssage
	 */
	public function setMessage ($msg) {
		$this->message = $msg;
	}

}
