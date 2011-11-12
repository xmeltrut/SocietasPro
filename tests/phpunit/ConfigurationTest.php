<?php
/**
 * Test the configuration object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 */

class ConfigurationTest extends PHPUnit_Framework_TestCase {

	private $object;
	
	function setUp () {
		require_once("../../library/classes/Configuration.php");
	}
	
	public function testGet () {
		$value = Configuration::get("language");
		$this->assertGreaterThan(false, $value);
	}

}