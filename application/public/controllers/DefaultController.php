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
	
		// get homepage
		$page = $this->model->getHomepage();
		if ($page === false) { throw new \HttpErrorException(404); }
		
		// output page
		$this->engine->assign("page", $page);
		$this->engine->display("page.tpl");
	
	}
	
	public function page () {
	
		// get page
		$page = $this->model->getBySlug(\FrontController::getParam(0), false);
		if ($page === false) { throw new \HttpErrorException(404); }
		
		// output page
		$this->engine->assign("page", $page);
		$this->engine->display("page.tpl");
	
	}

}
