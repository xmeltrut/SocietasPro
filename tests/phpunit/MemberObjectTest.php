<?php
class MemberObjectTest extends PHPUnit_Framework_TestCase {

	private $object;
	
	function setUp () {
		require_once("../application/admin/objects/Member.php");
		$this->object = new Member();
	}
	
	public function testSetAddress () {
		$value = "123 Fake Street";
		$this->object->setAddress($value);
		$this->assertEquals($this->object->getData("memberAddress"), $value);
	}
	
	public function testSetEmailAddress () {
		$value = "test@test.com";
		$this->object->setEmailAddress($value);
		$this->assertEquals($this->object->getData("memberEmail"), $value);
		
		$this->object->setEmailAddress("some-nonsense");
		$this->assertEquals($this->object->getData("memberEmail"), $value);
	}
	
	public function testSetForename () {
		$value = "David";
		$this->object->setForename($value);
		$this->assertEquals($this->object->getData("memberForename"), $value);
	}
	
	public function testSetNotes () {
		$value = "Example notes";
		$this->object->setNotes($value);
		$this->assertEquals($this->object->getData("memberNotes"), $value);
	}
	
	public function testSetPrivileges () {
		$value = 1;
		$this->object->setPrivileges($value);
		$this->assertEquals($this->object->getData("memberPrivileges"), $value);
		
		$this->object->setPrivileges(0);
		$this->assertEquals($this->object->getData("memberPrivileges"), $value);
	}
	
	public function testSetSurname () {
		$value = "Smith";
		$this->object->setSurname($value);
		$this->assertEquals($this->object->getData("memberSurname"), $value);
	}

}
