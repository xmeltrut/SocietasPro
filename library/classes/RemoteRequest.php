<?php
/**
 * Allows you to make remote requests
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 *
 * @todo Finish building this class
 */

class RemoteRequest {

	/**
	 * Determine whether we can use cURL or not.
	 */
	function __construct () {
	}
	
	/**
	 * Send the request
	 */
	public function send () {

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($ch);
		curl_close($ch);
		
	}

}