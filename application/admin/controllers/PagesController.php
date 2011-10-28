<?php
/**
 * Pages administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Add privileges to say standard or admin member
 * @todo Convert controllers to use cased filenames
 */

class PagesController extends BaseController implements iController {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		include_once("models/PagesModel.php");
		$this->model = new PagesModel();
	
	}
	
	/**
	 * Create a new page
	 */
	public function create () {
	
		// check for actions
		if (reqSet("action") == "create") {
			$this->model->create($_REQUEST["name"], $_REQUEST["content"]);
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// output the page
		$this->engine->assign("form", $this->standardForm("create"));
		$this->engine->display("pages/create.tpl");
	
	}
	
	/**
	 * Edit a page
	 */
	public function edit () {
	
		// get the current object
		$front = FrontController::getInstance();
		$page = $this->model->getById($front->getParam(0));
		
		// check for actions
		if (reqSet("action") == "edit") {
			$page->setName($_REQUEST["name"]);
			$page->setContent($_REQUEST["content"]);
			$this->model->save($page);
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// output the page
		$this->engine->assign("form", $this->standardForm("edit", $page->getAllData()));
		$this->engine->display("pages/edit.tpl");
	
	}
	
	/**
	 * Default page
	 */
	public function index () {
	
		// check for actions
		if (reqSet("action") == "delete") {
			$this->model->deleteById($_REQUEST["id"]);
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// get a list of pages
		$pages = $this->model->get();
		$this->engine->assign("pages", $pages);
		
		// output the page
		$this->engine->display("pages/index.tpl");
	
	}
	
	/**
	 * Create a standard form for editing pages
	 *
	 * @param string $action Form variable
	 * @param array $data Default values
	 */
	private function standardForm ($action, $data = array()) {
	
		require_once("formbuilder.php");
		
		$form = new FormBuilder();
		$form->addInput("name", LANG_NAME, arrSet($data, "pageName"));
		$form->addVisualEditor("content", arrSet($data, "pageContent"));
		$form->addHidden("id", arrSet($data, "pageID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		
		return $form->build();
	
	}

}
