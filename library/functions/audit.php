<?php
/**
 * Audit trail functions
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 *
 * @todo Audit trail should include user
 */

/**
 * Record an entry in the audit trail
 *
 * @param int $actionID ID of the action time
 * @param string $oldData Original data
 * @param string $newData Updated data
 * @return boolean Success
 */
function auditTrail ($actionID, $oldData = "", $newData = "") {

	// check data has changed
	if ($oldData != "" || $newData != "") {
		if ($oldData == $newData) {
			return false;
		}
	}
	
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
	return $db->query($sql);

}
