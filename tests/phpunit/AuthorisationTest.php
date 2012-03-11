<?php
/**
 * Test the authorisation object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 *
 * @todo Finish this
 */

class AuthorisationTest extends PHPUnit_Framework_TestCase {

	protected $object;
	
	protected function setUp () {
		$this->object = Authorisation::getInstance();
	}
	
	public function testConstruct () {
		$this->assertInstanceOf("Authorisation", $this->object);
	}
	
	public function testIsLoggedIn () {
		$value = $this->object->isLoggedIn();
		$this->assertFalse($value);
	}

}
