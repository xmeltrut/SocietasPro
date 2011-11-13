<?php
/**
 * Test the CSV Builder
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 */

class CsvBuilderTests extends PHPUnit_Framework_TestCase {

	private $object;
	
	/**
	 * Test the constructor
	 */
	public function testConstruct () {
	
		$this->object = new CsvBuilder("test");
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
