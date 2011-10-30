<?php
/**
 * Displays pages
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Public
 */

class PagesController extends BaseController implements iController {

	function __construct () {
		parent::__construct();
	}
	
	public function index () {
	
		$this->engine->display("default/homepage.tpl");
	
	}

}
