<?php
/**
 * Test the front controller
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Core
 */

class FrontControllerTest extends PHPUnit_Framework_TestCase {

	protected $object;
	
	protected function setUp () {
		$this->object = FrontController::getInstance();
	}
	
	public function testConstruct () {
		$this->assertInstanceOf("FrontController", $this->object);
	}
	
	public function testGetController () {
		$this->assertInternalType("string", $this->object->getController());
	}
	
	public function testGetModule () {
		$this->assertInternalType("string", $this->object->getModule());
	}
	
	public function testGetNamespace () {
		$this->assertInternalType("string", $this->object->getNamespace());
	}
	
	public function testGetPage () {
		$this->assertInternalType("string", $this->object->getPage());
	}
	
	public function testGetParam () {
		$this->assertFalse($this->object->getParam(0));
	}


}
