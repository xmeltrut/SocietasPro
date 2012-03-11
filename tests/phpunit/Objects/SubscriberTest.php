<?php
/**
 * Test the subscriber object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Objects
 */

class SubscriberTest extends PHPUnit_Framework_TestCase {

	protected $object;
	
	protected function setUp () {
		require_once("../../application/admin/objects/Subscriber.php");
		$this->object = new Subscriber();
	}
	
	public function testSetEmailAddress () {
		$this->assertTrue($this->object->setEmailAddress("test@example.com"));
		$this->assertFalse($this->object->setEmailAddress("not-a-valid-email-address!"));
		$this->assertSame($this->object->subscriberEmail, "test@example.com");
	}

}
