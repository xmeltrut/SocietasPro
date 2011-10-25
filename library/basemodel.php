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
	
		// check we have a table name defined
		if (!isset($this->tableName)) {
			return false;
		}
		
		// get data from object
		$data = $obj->getAllData();
		
		// build the identifier
		$idKey = substr($this->tableName, 0, -1)."ID";
		
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
			unset($data[$idKey]);
			
			$sql = "UPDATE ".DB_PREFIX.$this->tableName." SET ";
			$updateSql = "";
			
			foreach ($data as $key => $val) {
				$updateSql .= "$key = '".escape($val)."', ";
			}
			
			$sql .= substr($updateSql, 0, -2) . " ";
			$sql .= "WHERE $idKey = " . $data[$idKey];
			
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
