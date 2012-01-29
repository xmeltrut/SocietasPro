<?php
/**
 * Install function
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Installer
 */

function install ($groupName, $language, $email, $password, &$msg) {

	// validate input data
	if ($groupName == "") {
		$msg = "You did not enter the name of your group.";
		return false;
	} elseif ($email == "") {
		$msg = "You did not enter your email address.";
		return false;
	} elseif ($password == "") {
		$msg = "You did not enter a password.";
		return false;
	}
	
	// get the relevant SQL file
	$schema = "schema/".DB_TYPE.".sql";
	
	if (!($commands = parseSqlFile($schema))) {
		$msg = "Unable to locate database schema.";
		return false;
	}
	
	// install database
	$db = Database::getInstance();
	
	foreach ($commands as $command) {
		$command = trim($command);
		if ($command != "") {
			$sth = $db->prepare($command);
			if (!$sth->execute()) {
				$msg = "Query failed: ".$command;
				return false;
			}
		}
	}
	
	// configure config
	$sql = "UPDATE ".DB_PREFIX."config SET configValue = ? WHERE configOption = ? ";
	$sth = $db->prepare($sql);
	$sth->execute(array($groupName, "group_name"));
	$sth->execute(array($language, "language"));
	
	// encode user's password
	$auth = Authorisation::getInstance(false);
	$pass = $auth->encodePassword($password);
	
	// create a user
	$sql = "INSERT INTO ".DB_PREFIX."members (memberEmail, memberPassword, memberPrivileges)
			VALUES (?, ?, 2)";
	$sth = $db->prepare($sql);
	$sth->execute(array($email, $pass));
	
	// if we've got this far, it's a success!
	return true;

}
