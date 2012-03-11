<?php
/**
 * Test the language object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 */

class LanguageTest extends PHPUnit_Framework_TestCase {

	protected $object;
	
	protected function setUp () {
		$this->object = Language::getInstance();
	}
	
	public function testGetContent () {
		$this->assertInternalType("string", Language::getContent("email_sent"));
		$this->assertFalse(Language::getContent("thisIsClearlyNotAValidKey"));
	}
	
	public function testGetStrings () {
		$arr = $this->object->getStrings();
		$this->assertGreaterThan(0, count($arr));
	}
	
	public function testListAsArray () {
		$arr = $this->object->listAsArray();
		$this->assertGreaterThan(0, count($arr));
	}

}
