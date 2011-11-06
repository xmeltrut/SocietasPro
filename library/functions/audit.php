<?php
/**
 * Audit trail functions
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 *
 * @todo Can we use the AuditEntriesModel class?
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
	
	// insert it
	require_once("models/AuditEntriesModel.php");
	$auditEntriesModel = new AuditEntriesModel();
	return $auditEntriesModel->insert($actionID, $oldData, $newData);

}
