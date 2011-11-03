<?php
/**
 * Get a Twitter timeline.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Twitter
 *
 * @todo This should be called from an AJAX request
 * @todo Re-examine need for all the get functions
 */

require_once("twitter/Tweet.php");

class TwitterTimeline extends TwitterBase {

	private $response;
	private $screenName;
	private $count = 5;
	
	/**
	 * Constructor
	 *
	 * @param string $screenName Twitter username
	 */
	public function __construct ($screenName) {
	
		// check we have a screen name
		if ($screenName == "") {
			throw Exception("No screen name provided");
		} else {
			$this->screenName = $screenName;
		}
	
	}
	
	/**
	 * Make the call
	 */
	private function call () {
	
		// build parameters
		$params = array (
			"screen_name" => $this->screenName,
			"count" => $this->count,
			"include_rts" => "true",
			"include_entities" => "true"
		);
		
		// build URL
		$url = "https://api.twitter.com/1/statuses/user_timeline.json?";
		
		foreach ($params as $key => $val) {
			$url .= $key."=".$val."&";
		}
		
		// make curl request
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($ch);
		curl_close($ch);
		
		// save the response
		$this->response = $response;
	
	}
	
	/**
	 * Get the timeline as a series of Tweet objects
	 *
	 * @return array Tweets
	 */
	public function get () {
	
		// check we have a response
		if ($this->response == "") {
			$this->call();
		}
		
		// initialise array
		$arr = array();
		
		// loop through building objecrs
		foreach ($this->response as $data) {
			$arr[] = new Tweet($data);
		}
		
		// and return
		return $arr;
	
	}
	
	/**
	 * Get the timeline as an array
	 *
	 * @return array Tweets
	 */
	public function getAsArray () {
	
		// check we have a response
		if ($this->response == "") {
			$this->call();
		}
		
		// output response
		return json_decode($this->response, true);
	
	}
	
	/**
	 * Get the timeline as a json string
	 *
	 * @return string JSON
	 */
	public function getAsJsonString () {
	
		// check we have a response
		if ($this->response == "") {
			$this->call();
		}
		
		// output response
		return $this->response;
	
	}

}
