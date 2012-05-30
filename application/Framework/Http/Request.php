<?php
/**
 * Request object
 *
 * @author Chris Worfolk <chris@societaspro.org>
 *
 * @todo Move getParams and similar functions into this class
 */

namespace Framework\Http;

class Request {

	/**
	 * Use this to avoid PHP notices for unset indexes with form variables
	 *
	 * @param string $index Array index
	 * @return mixed
	 */
	public function set ($index) {
		if (isset($_REQUEST[$index])) {
			return $_REQUEST[$index];
		} else {
			return false;
		}
	}

}
