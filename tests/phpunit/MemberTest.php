<?php
/**
 * Test the member object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Objects
 *
 * @todo Finish this
 */

class MemberTest extends PHPUnit_Framework_TestCase {

	protected $object;
	
	protected function setUp () {
		require_once("../../application/common/objects/Member.php");
		$this->object = new Member();
	}
	
	public function testSetAddress () {
		$value = "123 Fake Street";
		$this->object->setAddress($value);
		$this->assertEquals($this->object->memberAddress, $value);
	}
	
	public function testSetEmailAddress () {
		$value = "test@test.com";
		$this->object->setEmailAddress($value);
		$this->assertEquals($this->object->memberEmail, $value);
		
		$this->object->setEmailAddress("some-nonsense");
		$this->assertEquals($this->object->memberEmail, $value);
	}
	
	public function testSetForename () {
		$value = "David";
		$this->object->setForename($value);
		$this->assertEquals($this->object->memberForename, $value);
	}
	
	public function testSetNotes () {
		$value = "Example notes";
		$this->object->setNotes($value);
		$this->assertEquals($this->object->memberNotes, $value);
	}
	
	public function testSetPrivileges () {
		$value = 1;
		$this->object->setPrivileges($value);
		$this->assertEquals($this->object->memberPrivileges, $value);
		
		$this->object->setPrivileges(0);
		$this->assertEquals($this->object->memberPrivileges, $value);
	}
	
	public function testSetSurname () {
		$value = "Smith";
		$this->object->setSurname($value);
		$this->assertEquals($this->object->memberSurname, $value);
	}

}
