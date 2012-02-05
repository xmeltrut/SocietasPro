<?php
/**
 * Members field is an object to represent a custom database column
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

class MembersField extends BaseObject {

	function __construct ($data = array()) {
		parent::__construct($data);
	}
	
	/**
	 * Get the options available
	 *
	 * @return array Options
	 */
	public function getOptions () {
	
		$options = explode("\n", $this->fieldOptions);
		array_walk($options, "trim");
		return $options;
	
	}
	
	/**
	 * Set the name of the field
	 *
	 * @param string $value Name
	 * @return boolean Success
	 */
	public function setName ($value) {
		if ($value == "") {
			$this->setMessage(LANG_INVALID." ".strtolower(LANG_NAME));
			return false;
		} else {
			$this->setData("fieldName", $value);
			return true;
		}
	}
	
	/**
	 * Set options
	 *
	 * @param string $value Options
	 * @return boolean Success
	 */
	public function setOptions ($value) {
		$this->setData("fieldOptions", $value);
		return true;
	
	}
	
	/**
	 * Set the field type
	 *
	 * @param string $value Type
	 * @return boolean Success
	 */
	public function setType ($value) {
		if ($value == "") {
			$this->setMessage(LANG_INVALID." ".strtolower(LANG_TYPE));
			return false;
		} else {
			$membersFieldsModel = new MembersFieldsModel();
			$types = $membersFieldsModel->getTypes();
			if (array_key_exists($value, $types)) {
				$this->setData("fieldType", $value);
				return true;
			} else {
				$this->setMessage(LANG_INVALID." ".strtolower(LANG_TYPE));
			return false;
			}
		}
	}

}
