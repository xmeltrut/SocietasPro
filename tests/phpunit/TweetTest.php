<?php
/**
 * Test the tweet object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 *
 * @todo Need to add some tests to this
 */

class TweetTest extends PHPUnit_Framework_TestCase {

	private $object;
	
	function setUp () {
		require_once("../library/twitter/Tweet.php");
		$this->object = new Tweet();
	}

}