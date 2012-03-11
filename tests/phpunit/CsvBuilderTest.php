<?php
/**
 * Test the CSV Builder
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 *
 * @todo Finish this
 */

class CsvBuilderTests extends PHPUnit_Framework_TestCase {

	private $object;
	
	public function setUp () {
		$this->object = new CsvBuilder("test");
	}
	
	/**
	 * Test the constructor
	 */
	public function testConstruct () {
	
		
		$this->assertInstanceOf("CsvBuilder", $this->object);
	
	}
	
	/**
	 * Test adding of rows
	 *
	 * @depends testConstruct
	 */
	public function testAddRow () {
	
		$arr = array("a", "b", "c");
		$result = $this->object->addRow($arr);
		$this->assertTrue($result);
	
	}

}
