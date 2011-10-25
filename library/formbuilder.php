<?php
/**
 * Generic way to build a form.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

class FormBuilder {

	/**
	 * Variable to hold the output HTML.
	 */
	private $output;
	
	/**
	 * Constructor.
	 *
	 * @param string $action Form action
	 * @param string $method POST or GET
	 *
	 */
	function __construct ($action = "", $method = "post") {
	
		$this->output = '<form action-"'.$action.'" method="'.$method.'"><ol>';
	
	}
	
	/**
	 * Add a date/time selector.
	 *
	 * @param string $name Name of the element
	 * @param string $label Label for input
	 */
	public function addDateTime ($name, $label) {
	
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
		
		$var = '<li>
					<label for="'.$name.'">'.$label.'</label>
					'.$this->returnSelect($name."[day]", $days).'
					'.$this->returnSelect($name."[month]", $months).'
					'.$this->returnInput($name."[year]", date("Y"), 4).'
					'.$this->returnSelect($name."[hour]", $hours).'
					'.$this->returnSelect($name."[minute]", $minutes).'
					'.$this->returnSelect($name."[second]", $seconds).'
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
	
		$var = '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
		$this->output .= $var;
	
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
					'.$this->returnInput($name, $default).'
				</li>';
		$this->output .= $var;
	
	}
	
	/**
	 * Add a submit button.
	 */
	public function addSubmit () {
	
		$var = '<li>
					<input type="submit" value="Submit" />
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
					<textarea name="'.$name.'" id="'.$name.'">'.h($default).'</textarea>
				</li>';
		$this->output .= $var;
	
	}
	
	/**
	 * Call this once the form is complete.
	 *
	 * @return string Form code
	 */
	public function build () {
	
		$this->output .= '</ol></form>';
		return $this->output;
	
	}
	
	/**
	 * Generate a text input box and return it
	 *
	 * @param string $name Name to give the element
	 * @param string $default Default value
	 * @param int $size Size attribute
	 * @return string HTML code
	 */
	private function returnInput ($name, $default = "", $size = 0) {
	
		$sizeCode = ($size > 0) ? 'size="'.$size.'"' : '';
	
		$var = '<input type="text" name="'.$name.'" id="'.$name.'" value="'.h($default).'" '.$sizeCode.' />';
		return $var;
	
	}
	
	/**
	 * Generate a select box and return it
	 *
	 * @param string $name Name to give the element
	 * @param array $options Associative array of value => label
	 * @return string HTML code
	 */
	private function returnSelect ($name, $options) {
	
		$var  = '<select name="'.$name.'">';
		foreach ($options as $key => $val) {
		$var .= '	<option value="'.$key.'">'.h($val).'</option>';
		}
		$var .= '</select>';
		return $var;
	
	}

}