<?php
/**
 * Array utilities
 *
 * @author Chris Worfolk <chris@societaspro.org>
 */

namespace Framework\Utilities;

class ArrayUtilities {

	/**
	 * Check if an array key exists and if so, return it
	 *
	 * @param array $arr Array
	 * @param string $index Array index
	 * @return mixed
	 */
	public static function set ($arr, $index) {
		if (array_key_exists($index, $arr)) {
			return $arr[$index];
		} else {
			return false;
		}
	}

}
