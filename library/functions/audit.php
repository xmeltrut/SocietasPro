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
 * @param string $oldData Original data
 * @param string $newData Updated data
 */
function auditTrail ($actionID, $oldData = "", $newData = "") {

	// get database
	$db = Database::getInstance();
	
	// build SQL statement
	$sql = "INSERT INTO ".DB_PREFIX."audit_entries (
			entryAction, entryDate, entryOldData, entryNewData
			) VALUES (
			".$actionID.",
			NOW(),
			'".escape($oldData)."',
			'".escape($newData)."'
			)";
	$db->query($sql);

}
