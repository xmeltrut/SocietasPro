<?php
/**
 * Test the tweet object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 */

class TweetTest extends PHPUnit_Framework_TestCase {

	private $object;
	
	function setUp () {
		require_once("../library/twitter/Tweet.php");
		$this->object = new Tweet();
	}
	
	public function testExample () {
		$this->assertTrue(false);
	}

}