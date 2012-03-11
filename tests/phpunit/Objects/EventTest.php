<?php
/**
 * Test the event model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Objects
 *
 * @todo Finish this
 */

class EventTest extends PHPUnit_Framework_TestCase {

	protected $object;
	
	protected function setUp () {
		require_once("../../application/common/objects/Event.php");
		$this->object = new Event();
	}
	
	public function testSetDescription () {
		$this->assertTrue($this->object->setDescription("Example"));
		$this->assertSame($this->object->eventDescription, "Example");
	}

}