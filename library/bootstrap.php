<?php
/**
 * Global include file to get us up and running.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

require("version.php");
require("classes/BaseController.php");
require("classes/Singleton.php");
require(ROOT_DIR."../personalisation/config.php");
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
