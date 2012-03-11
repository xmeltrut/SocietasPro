<?php
/**
 * Test the event model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Objects
 *
 * @todo Finish this
 */

class Admin_BlogControllerTest extends PHPUnit_Framework_TestCase {

	protected $object;
	
	public static function setUpBeforeClass () {
		require("../../application/admin/controllers/BlogController.php");
	}
	
	protected function setUp () {
		$this->object = new \admin\BlogController;
	}
	
	public function testCreate () {
		//$this->object->create();
	}

}
