<?php
/**
 * A generic error class. It will output a message to developers when
 * working in debug mode, or give users a 500 on live systems.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Exceptions
 */

namespace Exceptions;

class GeneralException extends \Exception {

	/**
	 * Constructor
	 *
	 * @param string $msg Message
	 */
	function __construct ($msg) {
	
		if (MODE == "DEBUG") {
		
			print $msg;
			exit(1);
		
		} else {
		
			throw new HttpErrorException(500, false);
		
		}

	
	}

}
