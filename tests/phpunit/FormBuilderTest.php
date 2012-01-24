<?php
/**
 * Test form builder
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Library
 */

class FormBuilderTest extends PHPUnit_Framework_TestCase {

	private $object;
	
	public static function setUpBeforeClass () {
		require_once("../../library/classesFormBuilder.php");
		$this->object = new FormBuilder();
	}

}
