<?php
/**
 * Main entry point for the front end. The front end doesn't exist yet, so let's just
 * send them straight to the admin panel.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

require("bootstrap.php");

// create a front controller
require("classes/FrontController.php");
$front = FrontController::getInstance();

// check if the user is logged in
if ($front->getModule() == "admin") {
	$auth = Authorisation::getInstance();
	if (!$auth->isLoggedIn()) {
		redirect("system/auth/login");
	}
}

// execute URL
$front->execute();
