<?php
/**
 * Base object, because coding getters and setters for every single object
 * is far too tedious. Instead, we can use generic ones and deal with the 
 * fall out later.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 *
 * @todo Make use of the magic getter is admin module
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
	 * @return string Message
	 */
	public function getMessage () {
		return $this->message;
	}
	
	/**
	 * Get data by array key. Protected because you should override
	 * it to strip out the need for a prefix.
	 *
	 * @param string $key Array key
	 * @return mixed Value
	 */
	public function getData ($key) {
		if (isset($this->data[$key])) {
			return $this->data[$key];
		} else {
			return false;
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
	protected function setData($key, $value) {
		$this->data[$key] = $value;
	}
	
	/**
	 * Set the return message
	 *
	 * @param string $msg Message
	 */
	protected function setMessage ($msg) {
		$this->message = $msg;
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