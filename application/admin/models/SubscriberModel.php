<?php
/**
 * Mailing list model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("basemodel.php");
require_once("objects/event.php");

class SubscriberModel extends BaseModel {

	protected $tableName = "subscribers";
	
	function __construct () {
		parent::__construct();
	}

}
