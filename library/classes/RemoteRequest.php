<?php
/**
 * Allows you to make remote requests
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 */

class RemoteRequest {

	private $url;
	private $params;
	private $response;
	
	/**
	 * Constructor. Initialise the URL variable.
	 *
	 * @param string $url URL
	 */
	function __construct ($url) {
	
		$this->url = $url;
	
	}
	
	/**
	 * Build the complete URL
	 *
	 * @return string URL
	 */
	private function buildUrl () {
	
		$url = $this->url."?";
		
		foreach ($this->params as $key => $val) {
			$url .= $key."=".$val . "&";
		}
		
		return $url;
	
	}
	
	/**
	 * Get the response
	 *
	 * @return string Response
	 */
	public function getResponse () {
	
		return $this->response;
	
	}
	
	/**
	 * Send the request\
	 *
	 * @return boolean Success
	 */
	public function send () {
	
		// send the request
		if (function_exists("curl_init")) {
			$response = $this->sendViaCurl();
		} else {
			$response = $this->sendViaFgc();
		}
		
		// save data and return
		if ($response === false) {
			return false;
		} else {
			$this->response = $response;
			return true;
		}
	
	}
	
	/**
	 * Send the request using cURL
	 *
	 * @return string Content returned from request or false on fail
	 */
	private function sendViaCurl () {
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->buildUrl());
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	
	}
	
	/**
	 * Send the request via file_get_contents
	 *
	 * @return string Content returned from the request or false on fail
	 */
	private function sendViaFgc () {
	
		$response = file_get_contents($this->buildUrl());
		return  $response;
	
	}
	
	/**
	 * Set a parameter
	 *
	 * @param string $key Key
	 * @param string $val Value
	 */
	public function setParam ($key, $val) {
	
		// basic validation
		if ($key == "") {
			return false;
		}
		
		// set the parameter
		$this->params[$key] = $val;
		return true;
	
	}

}