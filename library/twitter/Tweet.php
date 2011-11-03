<?php
/**
 * Representation of a tweet
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Twitter
 *
 * @todo Re-examine this once done
 */

class Tweet {

	private $data;
	private $twitterData;
	
	/**
	 * Constructor.
	 *
	 * @param array $arr Data array
	 */
	function __construct ($arr) {
	
		$this->twitterData = $arr;
		$this->populate();
	
	}
	
	/**
	 * Magic getter function
	 *
	 * @param string $key Array key
	 * @return mixed
	 */
	public function __get ($key) {
	
		if (array_key_exists($key, $this->data)) {
			return $this->data[$key];
		} els {
			return false;
		}
	
	}
	
	/**
	 * Return the output as an array
	 *
	 * @return array
	 */
	public function getAsArray () {
	
		return $this->data;
	
	}
	
	/**
	 * Get an encoded version of the text for the tweet
	 *
	 * @return string Encoded text
	 */
	private function getEncodedText () {
	
		return $this->twitterData["text"];
	
	}
	
	/**
	 * Populate array from the twitter data.
	 */
	private function populate () {
	
		// build variables
		$time = strtotime($this->twitterData["created_at"]);
		
		// build array
		$arr = array (
			"id" => $this->twitterData["id"],
			"longDate" => date("j F Y, H:i", $time);
			"text" => $this->getEncodedText()
		);
		
		// save to instance variable
		$this->data = $arr;
	
	}

}
