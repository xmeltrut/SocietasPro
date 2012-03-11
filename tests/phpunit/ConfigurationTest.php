<?php
/**
 * Test the configuration object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 */

class ConfigurationTest extends PHPUnit_Framework_TestCase {
	
	public function testGet () {
	
		// test a valid option
		$value = Configuration::get("language");
		$this->assertGreaterThan(false, $value);
		
		// test an invalid option
		$this->assertFalse(Configuration::get("not-a-valid-configuration-option"));
	
	}
	
	public function testGetUrl () {
		$this->assertInternalType("string", Configuration::getUrl());
	}

}