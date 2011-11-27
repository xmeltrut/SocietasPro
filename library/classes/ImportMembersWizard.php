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
		
		// get custom fields too
		$fieldsModel = new membersFieldsModel();
		$fields = $fieldsModel->get();
		
		foreach ($fields as $field) {
			$arr["custom".$field->fieldID] = $field->fieldName;
		}
		
		// assign to instance variable
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
	 * Import the data using a map of csv column index => database column name
	 *
	 * @param array $map Map
	 * @return string Feedback
	 */
	public function importUsingMap ($map) {
	
		// initialise variables
		$successCount = 0;
		$failCount = 0;
		$headerRow = true;
		$membersModel = new MembersModel();
		$membersFieldsModel = new MembersFieldsModel();
		
		// loop through results
		foreach ($this->data as $rowString) {
		
			// skip header row
			if ($headerRow) {
				$headerRow = false;
				continue;
			}
			
			// extract data
			$row = str_getcsv($rowString);
			
			// build data
			$data = array (
				"address" => $row[$map["Address"]],
				"email" => $row[$map["Email"]],
				"forename" => $row[$map["Forename"]],
				"notes" => $row[$map["Notes"]],
				"password" => "",
				"privileges" => 1,
				"surname" => $row[$map["Surname"]]
			);
			
			// add custom fields
			$fields = $membersFieldsModel->get();
			foreach ($fields as $field) {
				if (isset($row[$map["custom".$field->fieldID]])) {
					$value = $row[$map["custom".$field->fieldID]];
				} else {
					$value = "";
				}
				$data["custom".$field->fieldID] = $value;
			}
			
			// write member
			if ($membersModel->write($data)) {
				$successCount++;
			} else {
				$failCount++;
			}
		
		}
		
		// return result
		return LANG_SUCCESS.": ".$successCount.", ".LANG_FAILED.": ".$failCount;
	
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
