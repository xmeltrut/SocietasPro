<?php
/**
 * Bootstrap for running tests
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package UnitTests
 * @subpackage Core
 */

define("ROOT_DIR", "../");
require("../../library/bootstrap.php");

// autoload function
function autoloadForTest($className) {
	
}

// register autoload function
spl_autoload_register("autoloadForTest");
