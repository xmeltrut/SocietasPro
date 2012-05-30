<?php
/**
 * Audit trail object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

namespace Framework\Logging;

use Model;

class AuditTrail {

	/**
	 * Record an entry in the audit trail
	 *
	 * @param int $actionID ID of the action time
	 * @param string $oldData Original data
	 * @param string $newData Updated data
	 * @return boolean Success
	 */
	function log ($actionID, $oldData = "", $newData = "") {
	
		// check data has changed
		if ($oldData != "" || $newData != "") {
			if ($oldData == $newData) {
				return false;
			}
		}
		
		// insert it
		$auditEntriesModel = new Model\AuditEntriesModel();
		return $auditEntriesModel->insert($actionID, $oldData, $newData);
	
	}

}

