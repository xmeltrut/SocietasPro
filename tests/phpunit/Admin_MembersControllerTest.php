<?php
/**
 * Test the members controller
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Controllers
 */

class MembersControllerTest extends PHPUnit_Framework_TestCase {

	private $object;
	
	public static function setUpBeforeClass () {
		require_once("../../library/classes/BaseController.php");
		require_once("../../library/classes/FrontController.php");
		//require_once("../../library/iController.php");
		require_once("../../application/admin/controllers/MembersController.php");
		$this->object = new \admin\MembersController();
	}
	
	public function testExample () {
		$this->assertTrue(false);
	}

}