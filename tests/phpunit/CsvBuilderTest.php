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

class CsvBuilderTest extends PHPUnit_Framework_TestCase {

	protected $object;
	protected $sampleData;
	
	protected function setUp () {
		$this->object = new CsvBuilder("test");
		$this->sampleData = array("a", "b", "c");
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
		$result = $this->object->addRow($this->sampleData);
		$this->assertTrue($result);
	}
	
	/**
	 * Test output
	 *
	 * @depends testAddRow
	 */
	/*public function testOutput () {
		$this->expectOutputString(implode(",", $this->sampleData));
		$this->object->output(false);
	}*/

}
