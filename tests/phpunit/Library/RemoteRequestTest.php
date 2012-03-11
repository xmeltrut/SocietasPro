<?php
/**
 * Test the remote request object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 */

class RemoteRequestTest extends PHPUnit_Framework_TestCase {

	protected $object;
	
	protected function setUp () {
		$this->object = new RemoteRequest("http://www.societaspro.org/api");
	}
	
	public function testSetParam () {
		$this->assertTrue($this->object->setParam("testParam", "testValue"));
		$this->assertFalse($this->object->setParam("", "testValue"));
	}
	
	/**
	 * @depends testSetParam
	 */
	public function testSend () {
		$result = $this->object->send();
		$this->assertTrue($result);
	}

}
