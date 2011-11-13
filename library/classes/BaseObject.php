<?php
/**
 * Base object, because coding getters and setters for every single object
 * is far too tedious. Instead, we can use generic ones and deal with the
 * fall out later.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

abstract class BaseObject {

	/**
	 * Array to hold generic data for the object. We also need to hold
	 * the original data so we can compare in the audit logs.
	 */
	private $data;
	private $originalData;
	
	/**
	 * Variable to hold a return message.
	 */
	private $message;
	
	/**
	 * Constructor.
	 *
	 * @param array $data Array of data to populate the object with
	 */
	function __construct ($data) {
		$this->data = $this->originalData = $data;
	}
	
	/**
	 * Magic getter
	 *
	 * @param string $key Key
	 * @return mixed
	 */
	public function __get ($key) {
		if (array_key_exists($key, $this->data)) {
			return $this->data[$key];
		} else {
			return false;
		}
	}
	
	/**
	 * We need a toString method so we can record it in the audit trail
	 *
	 * @return string Data in object
	 */
	public function __toString () {
		return json_encode($this->data);
	}
	
	/**
	 * Get all data (used for save functions)
	 */
	public function getAllData () {
		return $this->data;
	}
	
	/**
	 * Standard get return message function
	 *
	 * @return string|array Message
	 */
	public function getMessage () {
		return $this->message;
	}
	
	/**
	 * Check if a data element has been updated
	 *
	 * This will return false if the element doesn't exist, except if it exsits in one instance and
	 * not the other, in which case it will return true. It does not use strict type checking.
	 *
	 * @param string $key Key
	 * @return boolean
	 */
	public function hasChanged ($key = false) {
	
		if ($key) {
		
			// run both checks
			$a = array_key_exists($key, $this->data);
			$b = array_key_exists($key, $this->originalData);
		
			if ($a || $b) {
				if ($a && $b) {
					if ($this->data[$key] == $this->originalData[$key]) {
						return false;
					} else {
						return true;
					}
				} else {
					return true;
				}
			} else {
				return false;
			}
		
		} else {
		
			$arr = array_diff_assoc($this->data, $this->originalData);
			
			if (count($arr) > 0) {
				return true;
			} else {
				return false;
			}
		
		}
	
	}
	
	/**
	 * Returns a string representation of the data as it was when the object
	 * was originally created - perfect for audit trails.
	 *
	 * @return string Data
	 */
	public function original () {
		if (is_array($this->originalData)) {
			if (count($this->originalData) > 0) {
				return json_encode($this->originalData);
			}
		}
		return "";
	}
	
	/**
	 * Set a data element. Only available to child objects.
	 *
	 * @param string $key Key
	 * @param string $value Value
	 */
	protected function setData ($key, $value) {
		$this->data[$key] = $value;
	}
	
	/**
	 * Set the return message
	 *
	 * @param string $msg Message
	 * @return boolean Success
	 */
	protected function setMessage ($msg) {
	
		if ($msg != "") {
			if (is_array($this->message)) {
				$this->message[] = $msg;
			} elseif ($this->message != "") {
				$this->message = array($this->message, $msg);
			} else {
				$this->message = $msg;
			}
			
			return true;
		}
		
		return false;
	
	}
	
	/**
	 * Unset an element from the data array
	 *
	 * @param string $key Key to unset
	 * @return boolean Success
	 */
	protected function unsetData ($key) {
		if (array_key_exists($key, $this->data)) {
			unset($this->data[$key]);
			return true;
		} else {
			return false;
		}
	}

}