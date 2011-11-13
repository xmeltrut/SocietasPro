<?php
/**
 * Main entry point
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
 *
 * @todo Implement support for namespaces with unit test scanning
 * @todo Implement checking for correct syntax such as functions ()
 */

// include essentials
require("includes/constants.php");
require("includes/functions.php");

// include interfaces
require("interfaces/iScanner.php");

// create main cursor
$scanner = new DirectoryCursor();
$messages = $scanner->scan();

// create a report
require("../../library/smarty/Smarty.class.php");
$template = new Smarty();
$template->assign("messages", $messages);
$template->display("views/report.tpl");
