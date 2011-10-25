<?php
/**
 * Base object, because coding getters and setters for every single object
 * is far too tedious. Instead, we can use generic ones and dead with the 
 * fall out later.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

class BaseObject {

	/**
	 * Array to hold generic data for the object.
	 */
	protected $data;
	
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
		$this->data = $data;
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

}