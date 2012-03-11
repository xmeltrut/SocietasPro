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
	require("../../library/templates/{$className}.php");
}

// register autoload function
spl_autoload_register("autoloadForTest");

// set the include path
$includePaths = array (
	"../../library",
	"../../application/common"
);

foreach ($includePaths as $path) {
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
}

// start the session
SessionManager::getInstance(false);

