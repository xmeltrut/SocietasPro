<?php
/**
 * Displays pages
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Public
 */

namespace publica;

class DefaultController extends \BaseController implements \iController {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/PagesModel.php");
		$this->model = new \PagesModel();
	
	}
	
	public function index () {
	
		// get posts
		
		$this->engine->display("homepage.tpl");
	
	}

}
