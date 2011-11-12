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
		require_once("../library/classes/Configuration.php");
		$this->object = Configuration::getInstance();
	}
	
	public function testGet () {
		$value = $this->object->get("language");
		$this->assertGreaterThan(false, $value);
	}

}