<?php
/**
 * Base model for models to extend from.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

namespace Framework\Abstracts;

use Framework\Database\Database;

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
	
		$this->db = Database::getInstance();
	
	}
	
	/**
	 * Delete an object in this table by it's ID
	 *
	 * @param int|array $ids IDs to delete
	 * @param int $auditAction Audit trail action ID
	 * @return boolean
	 */
	public function deleteById ($ids, $auditAction = false) {
	
		// initialise variables
		$successCount = 0;
		
		// build the identifier
		if (!$idKey = $this->getIdentifier()) {
			return false;
		}
		
		// create an array of IDs
		if (!is_array($ids)) {
			$ids = array ( $ids );
		}
		
		// clean the array
		array_walk($ids, "intval");
		
		// loop through IDs
		foreach ($ids as $id) {
		
			// get the data
			$sql = "SELECT * FROM ".DB_PREFIX.$this->tableName."
					WHERE ".$this->getIdentifier()." = ".$id;
			$rec = $this->db->query($sql);
			
			if ($row = $rec->fetch()) {
			
				// run delete SQL
				$sql = "DELETE FROM ".DB_PREFIX.$this->tableName."
						WHERE ".$this->getIdentifier()." = ".$id;
				$delResult = $this->db->query($sql);
				
				// if successful
				if ($delResult) {
				
					// add to count
					$successCount++;
					
					// log to audit trail
					if ($auditAction) {
						auditTrail($auditAction, json_encode($row));
					}
				
				}
			
			}
		
		}
		
		// provide feedback
		if ($successCount > 0) {
			$this->setMessage(LANG_SUCCESS);
			return true;
		} else {
			$this->setMessage(LANG_FAILED);
			return false;
		}
	
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
		
		$parts = explode("_", $this->tableName);
		$finalPart = $parts[(count($parts) - 1)];
		
		return substr($finalPart, 0, -1)."ID";
	
	}
	
	/**
	 * Get the return message
	 *
	 * @return string|array Message
	 */
	public function getMessage () {
		return $this->message;
	}
	
	/**
	 * Generic save function. Object is passed in as a reference so we can update
	 * the ID on an insert and use it in the function that calls this one.
	 *
	 * @param object $obj Object to save
	 * @return boolean
	 */
	public function save (&$obj) {
	
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
			$plac = array();
			$vals = array();
			
			foreach ($data as $key => $val) {
				$keys[] = $key;
				$plac[] = "?";
				$vals[] = $val;
			}
			
			// this is an insert
			$sql = "INSERT INTO ".DB_PREFIX.$this->tableName." (".implode($keys, ",").") VALUES (".implode($plac, ",").")";
			$sth = $this->db->prepare($sql);
			$rv  = $sth->execute($vals);
			
			// if successful, reload
			if ($rv) {
				$obj = $this->getById($this->db->lastInsertId());
			}
		
		} else {
		
			// this is an update
			$identifier = $data[$idKey];
			unset($data[$idKey]);
			
			$sql = "UPDATE ".DB_PREFIX.$this->tableName." SET ";
			$updateSql = "";
			$updateVars = array();
			
			foreach ($data as $key => $val) {
				$updateSql .= "$key = ?, ";
				$updateVars[] = $val;
			}
			
			$sql .= substr($updateSql, 0, -2) . " ";
			$sql .= "WHERE $idKey = " . $identifier;
			
			$sth = $this->db->prepare($sql);
			$rv = $sth->execute($updateVars);
		
		}
		
		// return result
		return $rv;
	
	}
	
	/**
	 * Set a return message
	 *
	 * @param string $msg Mssage
	 * @param boolean $clearPrevious If set to true, it won't stack errors
	 * @return boolean Success
	 */
	public function setMessage ($msg, $clearPrevious = false) {
	
		if ($msg != "") {
		
			// convert it to an array
			if (!is_array($msg)) {
				$msg = array($msg);
			}
			
			// should we reset it first?
			if ($clearPrevious) {
				$this->message = "";
			}
			
			// loop through elements
			foreach ($msg as $str) {
			
				if (is_array($this->message)) {
					$this->message[] = $str;
				} elseif ($this->message != "") {
					$this->message = array($this->message, $str);
				} else {
					$this->message = $str;
				}
			
			}
			
			return true;
		
		}
		
		return false;
	
	}

}
