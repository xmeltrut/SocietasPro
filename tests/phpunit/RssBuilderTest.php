<?php
/**
 * Test the RSS builder
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 */

class RssBuilderTest extends PHPUnit_Framework_TestCase {

	protected $object;
	protected $timestamp;
	
	protected function setUp () {
		$this->object = new RssBuilder("Example", "Example", "http://www.example.com/");
		$this->timestamp = time();
	}
	
	public function testConstruct () {
		$this->assertInstanceOf("RssBuilder", $this->object);
	}
	
	public function testAddElement () {
	
		// valid entry
		$result = $this->object->addElement("Example", "Example", "http://www.example.com/", $this->timestamp);
		$this->assertTrue($result);
		
		// invalid entry
		$result = $this->object->addElement(false, false, false, false);
		$this->assertFalse($result);
	
	}
	
	public function restOutput () {
		$this->expectOutputRegex("/(.+)/");
		$this->object->output();
	}

}
