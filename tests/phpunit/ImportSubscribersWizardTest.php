<?php
/**
 * Test the import subscribers wizard
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 *
 * @todo Finish this
 */

class ImportSubscribersWizardTest extends PHPUnit_Framework_TestCase {

	protected $object;
	
	public static function setUpBeforeClass () {
		//require("../../application/admin/objects/Subscriber.php");
		//require("../../application/admin/models/SubscribersModel.php");
	}
	
	protected function setUp () {
		$this->object = new ImportSubscribersWizard();
	}
	
	public function testConstruct () {
		$this->assertInstanceOf("ImportSubscribersWizard", $this->object);
	}
	
	/**
	 * @dataProvider provider
	 */
	/*public function testImport ($data) {
	
		$response = $this->object->import($data);
		$this->assertSame("Success: 3, Failed: 0", $response);
	
	}*/
	
	/**
	 * Provides data for importing
	 */
	public function provider () {
	
		return array (
			array("a@example.com; b@example.com; c@example.com"),
			array("a@example.com, b@example.com, c@example.com"),
			array("a@example.com\nb@example.com\nc@example.com")
		);
	
	}

}
