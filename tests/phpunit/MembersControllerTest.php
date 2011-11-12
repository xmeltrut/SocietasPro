<?php
/**
 * Test the members controller
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Controllers
 *
 * @todo Add more tests
 */

class MembersControllerTest extends PHPUnit_Framework_TestCase {

	private $object;
	
	function setUp () {
		require_once("../application/admin/controllers/MembersController.php");
		$this->object = new MemberController();
	}

}