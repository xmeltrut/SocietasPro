<?php
/**
 * Global include file to get us up and running.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

require("basecontroller.php");
require("config.php");
require("configuration.php");
require("functions/audit.php");
require("functions/general.php");
require("functions/strings.php");
require("functions/validation.php");
require("constants.php");
require("icontroller.php");

// run functions
spl_autoload_register("autoload");
rebuildRequestArray();
