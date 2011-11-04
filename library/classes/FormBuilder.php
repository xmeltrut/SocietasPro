<?php
/**
 * Generic way to build a form.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 */

class FormBuilder {

	/**
	 * Variable to hold the output HTML.
	 */
	private $output;
	
	/**
	 * Form variables we need to save
	 */
	private $action;
	private $method;
	
	private $hasUpload = false;
	
	/**
	 * Constructor.
	 *
	 * @param string $action Form action
	 * @param string $method POST or GET
	 *
	 */
	function __construct ($action = "", $method = "post") {
	
		// save to instance variables
		$this->action = $action;
		$this->method = $method;
	
	}
	
	/**
	 * Add a date/time selector.
	 *
	 * @param string $name Name of the element
	 * @param string $label Label for input
	 * @param string $default ISO date format string
	 * @param boolean $includeSeconds Set to true to add a seconds box
	 */
	public function addDateTime ($name, $label, $default = false, $includeSeconds = false) {
	
		// build data arrays
		$days = array();
		for ($i = 1; $i <= 31; $i++) { $days[$i] = $i; }
		
		$months = array();
		for ($i = 1; $i <= 12; $i++) { $months[$i] = date('F', mktime(0,0,0,$i,1)); }
		
		$hours = array();
		for ($i = 0; $i <= 23; $i++) { $hours[sprintf("%02d", $i)] = sprintf("%02d", $i); }
		
		$minutes = array();
		for ($i = 0; $i <= 60; $i++) { $minutes[sprintf("%02d", $i)] = sprintf("%02d", $i); }
		
		$seconds = $minutes;
		
		// default values
		if ($default) {
			$dateString = strtotime($default);
			$defaultYear = date("Y", $dateString);
			$defaultMonth = date("n", $dateString);
			$defaultDay = date("j", $dateString);
			$defaultHour = date("G", $dateString);
			$defaultMinute = date("i", $dateString);
			$defaultSecond = date("s", $dateString);
		} else {
			$defaultYear = date("Y");
			$defaultMonth = date("n");
			$defaultDay = date("j");
			$defaultHour = 19;
			$defaultMinute = 0;
			$defaultSecond = 0;
		}
		
		// code for seconds
		if ($includeSeconds) {
			$secondsCode = $this->returnSelect($name."[second]", $seconds, $defaultSecond);
		} else {
			$secondsCode = $this->returnHidden($name."[second]",$defaultSecond); 
		}
		
		// build form elements
		$var = '<li>
					<label for="'.$name.'">'.$label.'</label>
					'.$this->returnSelect($name."[day]", $days, $defaultDay).'
					'.$this->returnSelect($name."[month]", $months, $defaultMonth).'
					'.$this->returnInput($name."[year]", $defaultYear, 4).'
					'.$this->returnSelect($name."[hour]", $hours, $defaultHour).'
					'.$this->returnSelect($name."[minute]", $minutes, $defaultMinute).'
					'.$secondsCode.'
				</li>';
		$this->output .= $var;
	
	}
	
	/**
	 * Add a file upload input.
	 *
	 * @param string $name Name of the element
	 * @param string $label Label
	 */
	public function addFile ($name, $label, $default = "") {
	
		// set this form as having an upload component
		$this->hasUpload = true;
		
		// add element to the form
		$var = '<li>
					<label for="'.$name.'">'.$label.'</label>
					'.$this->returnInput($name, $default, 0, "", "file").'
				</li>';
		$this->output .= $var;
	
	}
	
	/**
	 * Add a hidden input field.
	 *
	 * @param string $name Name of the element
	 * @param string $value Value
	 */
	public function addHidden ($name, $value) {
	
		$this->output .= $this->returnHidden($name, $value);
	
	}
	
	/**
	 * Add a text input to the form.
	 *
	 * @param string $name Name to give the element
	 * @param string $label Text for label
	 * @param string $default Dafault value
	 */
	public function addInput ($name, $label, $default = "") {
	
		$var = '<li>
					<label for="'.$name.'">'.$label.'</label>
					'.$this->returnInput($name, $default, 0, "stdRow").'
				</li>';
		$this->output .= $var;
	
	}
	
	/**
	 * Add a dropdown menu
	 *
	 * @param string $name Name to give the lement
	 * @param string $label Text for label
	 * @param array $options Options to populate the select with
	 * @param string $default Default value
	 */
	public function addSelect ($name, $label, $options, $default = false) {
	
		$var = '<li>
					<label for="'.$name.'">'.$label.'</label>
					'.$this->returnSelect($name, $options, $default).'
				</li>';
		$this->output .= $var;
	
	}
	
	/**
	 * Add a submit button.
	 */
	public function addSubmit () {
	
		$var = '<li>
					<input type="submit" value="'.LANG_SUBMIT.'" />
				</li>';
		$this->output .= $var;
	
	}
	
	/**
	 * Add a text area
	 *
	 * @param string $name Name to give the element
	 * @param string $label Text for label
	 * @param string $default Dafault value
	 */
	public function addTextArea ($name, $label, $default = "") {
	
		$var = '<li>
					<label for="'.$name.'">'.$label.'</label>
					<textarea name="'.$name.'" id="'.$name.'" class="stdRow">'.h($default).'</textarea>
				</li>';
		$this->output .= $var;
	
	}
	
	/**
	 * Add a visual editor
	 *
	 * @param string $name Nam of element
	 * @param string $default Default value
	 */
	public function addVisualEditor ($name, $default = "") {
	
		$var = '<li>
					<textarea name="'.$name.'" id="'.$name.'" class="visualEditor">'.h($default).'</textarea>
				</li>';
		$this->output .= $var;
	
	}
	
	/**
	 * Call this once the form is complete.
	 *
	 * @return string Form code
	 */
	public function build () {
	
		$enctype = ($this->hasUpload) ? 'enctype="multipart/form-data"' : '';
		
		$this->output  = '<form action="'.$this->action.'" method="'.$this->method.'" '.$enctype.'><ol>'.$this->output;
		$this->output .= '</ol></form>';
		return $this->output;
	
	}
	
	/**
	 * Return a hidden input field.
	 *
	 * @param string $name Name of the element
	 * @param string $value Value
	 * @return string HTML code
	 */
	public function returnHidden ($name, $value) {
	
		$var = '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
		return $var;
	
	}
	
	/**
	 * Generate a text input box and return it
	 *
	 * @param string $name Name to give the element
	 * @param string $default Default value
	 * @param int $size Size attribute
	 * @param string $class Class name
	 * @param string $type Text, password or file
	 * @return string HTML code
	 */
	private function returnInput ($name, $default = "", $size = 0, $class = "", $type = "text") {
	
		$sizeCode = ($size > 0) ? 'size="'.$size.'"' : '';
	
		$var = '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" value="'.h($default).'" class="'.$class.'" '.$sizeCode.' />';
		return $var;
	
	}
	
	/**
	 * Generate a select box and return it
	 *
	 * @param string $name Name to give the element
	 * @param array $options Associative array of value => label
	 * @param string $default Default value
	 * @return string HTML code
	 */
	private function returnSelect ($name, $options, $default = false) {
	
		$var  = '<select name="'.$name.'">';
		foreach ($options as $key => $val) {
			$defaultCode = ($key == $default) ? 'selected="selected"' : '';
			$var .= '<option value="'.$key.'" '.$defaultCode.'>'.h($val).'</option>';
		}
		$var .= '</select>';
		return $var;
	
	}

}