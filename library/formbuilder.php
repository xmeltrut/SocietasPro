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
	
		$this->output = '<form action-"'.$action.'" method="'.$method.'">';
	
	}
	
	/**
	 * Add a date/time selector.
	 *
	 * @param string $name Name of the element
	 * @param string $label Label for input
	 */
	public function addDateTime ($name, $label) {
	
		$var = '<li>
					<label for="'.$name.'">'.$label.'</label>
					<select>
						<option>1</option>
					</select>
					<select>
						<option>January</option>
						<option>February</option>
						<option>March</option>
						<option>April</option>
						<option>May</option>
						<option>June</option>
						<option>July</option>
						<option>August</option>
						<option>September</option>
						<option>October</option>
						<option>November</option>
						<option>December</option>
					</select>
					<select>
						<option>2011</option>
					</select>
					<select>
						<option>00</option>
					</select>
					<select>
						<option>00</option>
					</select>
					<select>
						<option>00</option>
					</select>
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
					<input type="text" name="'.$name.'" id="'.$name.'" value="'.h($default).'" />
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
	
		$this->output .= '</form>';
		return $this->output;
	
	}

}