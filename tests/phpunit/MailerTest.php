<?php
/**
 * Test mailer
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 */

class MailerTest extends PHPUnit_Framework_TestCase {

	protected $object;
	
	protected function setUp () {
		$this->object = new Mailer();
	}
	
	public function testAddRecipient () {
		$this->assertTrue($this->object->addRecipient("test@example.com"));
		$this->assertFalse($this->object->addRecipient("not-a-valid-email!"));
	}
	
	public function testSetBody () {
		$this->assertTrue($this->object->setBody("Example body"));
	}
	
	public function testSetSender () {
		$this->assertTrue($this->object->setSender("sender@example.com"));
		$this->assertFalse($this->object->addRecipient("not-a-valid-email!"));
	}
	
	public function testSetSubject () {
		$this->assertTrue($this->object->setSubject("Example subject"));
	}

}
