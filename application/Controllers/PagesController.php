<?php
/**
 * Pages administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

namespace Controllers;

use Model;
use Framework\Abstracts\BaseController;
use Framework\Utilities\ArrayUtilities;
use Framework\Http\FrontController;
use Framework\Forms\FormBuilder;

class PagesController extends BaseControlle {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		$this->model = new Model\PagesModel();
	
	}
	
	/**
	 * Create a new page
	 */
	public function create ($request) {
	
		// check for actions
		if ($request->set("action") == "create") {
			$this->model->write($_REQUEST);
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// output the page
		$this->engine->assign("form", $this->standardForm("create"));
		$this->engine->display("pages/create.tpl");
	
	}
	
	/**
	 * Edit a page
	 */
	public function edit ($request) {
	
		// check for actions
		if ($request->set("action") == "edit") {
			$this->model->write($_REQUEST, FrontController::getParam(0));
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// get the object
		$page = $this->model->getById(FrontController::getParam(0));
		if ($page === false) { throw new \HttpErrorException(404); }
		
		// output the page
		$this->engine->assign("form", $this->standardForm("edit", $page->getAllData()));
		$this->engine->display("pages/edit.tpl");
	
	}
	
	/**
	 * Default page
	 */
	public function index ($request) {
	
		// check for actions
		if ($request->set("action") == "mass") {
			if ($info = $this->determineMassAction()) {
				switch ($info["action"]) {
					case "clone":
						$this->model->cloneById($info["ids"]);
						break;
					case "delete":
						$this->model->deleteById($info["ids"], 19);
						break;
					case "up":
						$this->model->moveUp($info["ids"]);
						break;
					case "down":
						$this->model->moveDown($info["ids"]);
						break;
				}
			}
			$this->engine->setMessage($this->model->getMessage());
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
	
		// build array of page parents
		$excludedID  = ($action == "edit") ? $data["pageID"] : 0;
		$pageParent  = array(0 => LANG_NONE);
		$pageParent += $this->model->getAsArray($excludedID);
		
		// status values
		$statusValues = array (
			"Published" => LANG_PUBLISHED,
			"Draft" => LANG_DRAFT
		);
		
		$form = new FormBuilder();
		$form->addInput("name", LANG_NAME, ArrayUtilities::set($data, "pageName"));
		$form->addInput("description", LANG_DESCRIPTION, ArrayUtilities::set($data, "pageDescription"));
		$form->addInput("slug", LANG_URL, ArrayUtilities::set($data, "pageSlug"));
		$form->addSelect("parent", LANG_PARENT, $pageParent, ArrayUtilities::set($data, "pageParent"));
		$form->addSelect("status", LANG_STATUS, $statusValues, ArrayUtilities::set($data, "pageStatus"));
		$form->addVisualEditor("content", ArrayUtilities::set($data, "pageContent"));
		$form->addHidden("id", ArrayUtilities::set($data, "pageID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		$form->setDefaultElement("name");
		
		return $form->build();
	
	}

}
