<?php
/**
 * This is the default page for the admin panel.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

class DefaultController extends BaseController implements iController {

	function __construct () {
		parent::__construct();
	}
	
	public function index () {
	
		$this->engine->display("default/index.tpl");
	
	}

}
