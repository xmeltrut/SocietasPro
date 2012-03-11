<?php
/**
 * Test the session manager object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 */

class SessionManagerTest extends PHPUnit_Framework_TestCase {

	/**
	 * Test the setting of a value
	 */
	public function testSet () {
		$session = SessionManager::getInstance();
		$this->assertTrue($session->set("test", 123));
		$this->assertFalse(false, "");
	}
	
	/**
	 * Testing the getting of a value
	 */
	public function testGet () {
		$session = SessionManager::getInstance();
		$this->assertSame($session->get("test"), 123);
		$this->assertFalse($session->get("not-a-valid-key"));
	}

}
