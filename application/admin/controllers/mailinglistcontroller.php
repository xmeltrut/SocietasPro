<?php
/**
 * Mailing list controller
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

class MailinglistController extends BaseController implements iController {

	function __construct () {
		parent::__construct();
	}
	
	public function index () {
	
		$this->engine->display("mailinglist/index.tpl");
	
	}

}
