<?php
/**
 * Test the tmp gateway object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 */

class TmpGatewayTest extends PHPUnit_Framework_TestCase {

	protected $object;
	
	protected function setUp () {
		$this->object = new TmpGateway();
	}
	
	public function testConstruct () {
		$this->assertInstanceOf("TmpGateway", $this->object);
	}
	
	public function testGetPath () {
		$path = $this->object->getPath();
		$this->assertTrue(file_exists($path));
	}
	
	public function testIsWritable () {
		$this->assertInternalType("boolean", $this->object->isWritable());
	}

}
