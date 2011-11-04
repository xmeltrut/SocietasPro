<?php
/**
 * Pages administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

class PagesController extends BaseController implements iController {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/PagesModel.php");
		$this->model = new PagesModel();
	
	}
	
	/**
	 * Create a new page
	 */
	public function create () {
	
		// check for actions
		if (reqSet("action") == "create") {
			$this->model->write($_REQUEST);
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
	
		// get a front controller
		$front = FrontController::getInstance();
		
		// check for actions
		if (reqSet("action") == "edit") {
			$this->model->write($_REQUEST, $front->getParam(0));
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// get the object
		$page = $this->model->getById($front->getParam(0));
		
		// output the page
		$this->engine->assign("form", $this->standardForm("edit", $page->getAllData()));
		$this->engine->display("pages/edit.tpl");
	
	}
	
	/**
	 * Default page
	 */
	public function index () {
	
		// check for actions
		if (reqSet("action") == "mass") {
			if ($info = $this->determineMassAction()) {
				switch ($info["action"]) {
					case "clone":
						$this->model->cloneById($info["ids"]);
						break;
					case "delete":
						$this->model->deleteById($info["ids"]);
						break;
				}
			}
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
	
		require_once("classes/FormBuilder.php");
		
		$pageParent = $this->model->getAsArray();
		$pageParent[0] = LANG_NONE;
		
		$form = new FormBuilder();
		$form->addInput("name", LANG_NAME, arrSet($data, "pageName"));
		$form->addInput("slug", LANG_URL, arrSet($data, "pageSlug"));
		$form->addSelect("parent", LANG_PARENT, $pageParent);
		$form->addVisualEditor("content", arrSet($data, "pageContent"));
		$form->addHidden("id", arrSet($data, "pageID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		
		return $form->build();
	
	}

}
