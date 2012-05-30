<?php
/**
 * Get a Twitter timeline.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Twitter
 */

namespace Framework\Twitter;

use Framework\Utilities\RemoteRequest;

class TwitterTimeline {

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
	
		// build request
		$request = new RemoteRequest("https://api.twitter.com/1/statuses/user_timeline.json");
		$request->setParam("screen_name", $this->screenName);
		$request->setParam("count", $this->count);
		$request->setParam("include_rts", "true");
		$request->setParam("include_entities", "true");
		
		// send request
		$status = $request->send();
		
		// process results
		if ($status) {
			$this->response = $request->getResponse();
		}
	
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
		$data = json_decode($this->response, true);
		
		foreach ($data as $tweet) {
			$arr[] = new Tweet($tweet);
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
