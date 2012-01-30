<?php
/**
 * Controls access to temperory file storage
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 */

class TmpGateway {

	/**
	 * The location on tmp in the filesystem
	 */
	private $tmpDir;
	
	/**
	 * Set the location of the tmp directory
	 */
	public function __construct () {
	
		if (defined("TMP_DIR")) {
		
			// allows config override
			$this->tmpDir = TMP_DIR;
		
		} else {
		
			// if we don't have the function, we'll have to create one
			if (!function_exists('sys_get_temp_dir')) {
				function sys_get_temp_dir() {
					if ( $temp=getenv('TMP') )     return $temp;
					if ( $temp=getenv('TEMP') )    return $temp;
					if ( $temp=getenv('TMPDIR') )  return $temp;
					$temp = tempnam(__FILE__,'');
					if (file_exists($temp)) {
						unlink($temp);
						return dirname($temp);
					}
					return false;
				}
			}
			
			// set the path
			$this->tmpDir = realpath(sys_get_temp_dir());
		
		}
	
	}
	
	/**
	 * Get path
	 *
	 * @return string Path
	 */
	public function getPath () {
		return $this->tmpDir;
	}
	
	/**
	 * Find out if the tmp directory is writable
	 *
	 * @return boolean
	 */
	public function isWritable () {
	
		if ($this->tmpDir) {
			if (is_writable($this->tmpDir)) {
				return true;
			}
		}
		
		return false;
	
	}

}
