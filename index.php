<?php
/**
 * SocietasPro main entry point
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

use Framework\Http\FrontController;

$configPath = "personalisation/config.php";
if (!file_exists($configPath)) {
	echo("Unable to locate your config.php file. Please create this before continuing.");
	exit(1);
}
require($configPath);

require_once("application/Framework/Core/Autoloader.php");
spl_autoload_register("\Framework\Core\Autoloader::load");

// include function libraries
require("application/Functions/General.php");
require("application/Functions/Strings.php");

define("ROOT_DIR", "./");

// create a front controller
$front = FrontController::getInstance();

// execute URL
$front->execute();
