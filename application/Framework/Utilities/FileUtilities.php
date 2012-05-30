<?php
/**
 * File utilities
 *
 * @author Chris Worfolk <chris@societaspro.org>
 */

namespace Framework\Utilities;

class FileUtilities {

	/**
	 * Search include paths for a file
	 *
	 * @param string $file Filenam
	 * @return boolean
	 */
	public static function exists ($file) {
		$paths = explode(":", ini_get('include_path'));
		foreach ($paths as $path) {
			if (file_exists($path.'/'.$file)) return true;
		}
		if (file_exists($file)) return true;
		return false;
	}

}
