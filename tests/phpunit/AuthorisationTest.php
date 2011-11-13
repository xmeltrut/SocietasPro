<?php
/**
 * Test the authorisation object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 */

class AuthorisationTest extends PHPUnit_Framework_TestCase {

	private $object;
	
	public static function setUpBeforeClass () {
		require_once("../../library/classes/Authorisation.php");
		$this->object = Authorisation::getInstance();
	}
	
	public function testIsLoggedIn () {
		$value = $this->object->isLoggedIn();
		$this->assertFalse($value);
	}

}
