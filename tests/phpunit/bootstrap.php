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
	$filePath = "../../library/classes/{$className}.php";
	if (file_exists($filePath)) {
		require($filePath);
	/*} else {
		print("Unable to locate $className\n");
		$e = new Exception;
		var_dump($e->getTraceAsString());
		exit(1);*/
	}
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

