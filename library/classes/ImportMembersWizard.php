<?php
/**
 * Import members wizard
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 */

class ImportMembersWizard {

	private $data;
	private $columns;
	
	/**
	 * Constructor
	 *
	 * @param array $arr Array, usually from a file() read
	 */
	function __construct ($arr) {
	
		// save data array
		if (is_array($arr)) {
			$this->data = $arr;
		} else {
			return false;
		}
		
		// build columns array
		$arr = array (
			"DROP" => LANG_DISCARD,
			"Address" => LANG_ADDRESS,
			"Email" => LANG_EMAIL,
			"Forename" => LANG_FORENAME,
			"Notes" => LANG_NOTES,
			"Surname" => LANG_SURNAME
		);
		
		$this->columns = $arr;
	
	}
	
	/**
	 * Return an array of the column headers
	 *
	 * @return array Column headers
	 */
	public function getColumnHeaders () {
	
		$headers = str_getcsv($this->data[0]);
		return $headers;
	
	}
	
	/**
	 * Get column options
	 *
	 * @return array Column options
	 */
	public function getColumnOptions () {
	
		return $this->columns;
	
	}
	
	/**
	 * Try and match the column header to a database column
	 *
	 * @param string $header Column header
	 * @return string Array key
	 */
	public function matchHeaderToColumn ($header) {
	
		return array_search($header, $this->columns);
	
	}

}
