<?php
/**
 * Import members wizard
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 *
 * @todo This should probably use http://php.net/manual/en/function.fgetcsv.php
 */

class ImportMembersWizard {

	private $data;
	
	/**
	 * Constructor
	 *
	 * @param array $arr Array, usually from a file() read
	 */
	function __construct ($arr) {
	
		if (is_array($arr)) {
			$this->data = $arr;
		} else {
			return false;
		}
	
	}
	
	/**
	 * Return an array of the column headers
	 *
	 * @return array Column headers
	 */
	public function getColumnHeaders () {
	}

}
