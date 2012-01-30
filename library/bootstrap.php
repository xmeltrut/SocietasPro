<?php
/**
 * Global include file to get us up and running.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

// check for config file
$configPath = ROOT_DIR."../personalisation/config.php";
if (!file_exists($configPath)) {
	die("Unable to locate your config.php file. Please create this before continuing.");
}

// include files
require("version.php");
require("classes/BaseController.php");
require("classes/Singleton.php");
require($configPath);
require("classes/Configuration.php");

require("functions/audit.php");
require("functions/general.php");
require("functions/strings.php");
require("functions/validation.php");

require("constants.php");

require("interfaces/iController.php");
require("interfaces/iModel.php");

// run functions
spl_autoload_register("autoload");
rebuildRequestArray();
