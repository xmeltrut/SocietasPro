<?php
/**
 * Main entry point
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
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
require("smarty/Smarty.class.php");
$template = new Smarty();
$template->assign("messages", $messages);
$template->display("views/report.tpl");
