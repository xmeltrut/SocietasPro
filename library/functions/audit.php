<?php
/**
 * Audit trail functions
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

/**
 * Record an entry in the audit trail
 *
 * @param int $actionID ID of the action time
 */
function auditTrail ($actionID) {

	// get database
	$db = Database::getInstance();
	
	// build SQL statement
	$sql = "INSERT INTO ".DB_PREFIX."audit_entries (
			entryAction, entryDate
			) VALUES (
			".$actionID.",
			NOW()
			)";
	$db->query($sql);

}
