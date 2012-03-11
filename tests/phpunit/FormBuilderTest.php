<?php
/**
 * Test form builder
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 *
 * @todo Finish this
 */

class FormBuilderTest extends PHPUnit_Framework_TestCase {

	private $object;
	
	public function setUp () {
		$this->object = new FormBuilder();
	}
	
	public function testConstruct () {
		$this->assertInstanceOf("FormBuilder", $this->object);
	}

}
