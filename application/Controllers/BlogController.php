<?php
/**
 * Blog administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

namespace Controllers;

use Model\BlogPostsModel;
use Framework\Core\Controller;
use Framework\Utilities\Pagination;
use Framework\Utilities\ArrayUtilities;
use Framework\Http\FrontController;
use Framework\Forms\FormBuilder;

class BlogController extends Controller {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		$this->model = new BlogPostsModel();
	
	}
	
	/**
	 * Create a new blog post
	 */
	public function create ($request) {
	
		// check actions
		if ($request->set("action") == "create") {
			$this->model->write($_REQUEST);
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// output page
		$this->engine->assign("form", $this->standardForm("create"));
		$this->engine->display("blog/create.tpl");
	
	}
	
	/**
	 * Edit an event
	 */
	public function edit ($request) {
	
		// check for actions
		if ($request->set("action") == "edit") {
			$this->model->write($_REQUEST, FrontController::getParam(0));
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// get the object
		$post = $this->model->getById(FrontController::getParam(0));
		if ($post === false) { throw new \HttpErrorException(404); }
		
		// output page
		$this->engine->assign("form", $this->standardForm("edit", $post->getAllData()));
		$this->engine->display("blog/edit.tpl");
	
	}
	
	/**
	 * Default page
	 */
	public function index ($request) {
	
		// check for actions
		if ($request->set("action") == "mass") {
			if ($info = $this->determineMassAction()) {
				switch ($info["action"]) {
					case "delete":
						$this->model->deleteById($info["ids"], 18);
						break;
				}
			}
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// gather page variables
		$pageNum = Pagination::pageNum(FrontController::getParam(0));
		$totalPages = Pagination::totalPages($this->model->count());
		$posts = $this->model->get($pageNum);
		
		// output page
		$this->engine->assign("posts", $posts);
		$this->engine->assign("pageNum", $pageNum);
		$this->engine->assign("totalPages", $totalPages);
		$this->engine->display("blog/index.tpl");
	
	}
	
	/**
	 * Create a standard form for editing posts
	 *
	 * @param string $action Form variable
	 * @param array $data Default values
	 */
	private function standardForm ($action, $data = array()) {
	
		// status values
		$statusValues = array (
			"Published" => LANG_PUBLISHED,
			"Draft" => LANG_DRAFT
		);
		
		$form = new FormBuilder();
		$form->addInput("name", LANG_NAME, ArrayUtilities::set($data, "postName"));
		$form->addInput("slug", LANG_URL, ArrayUtilities::set($data, "postSlug"));
		$form->addSelect("status", LANG_STATUS, $statusValues, ArrayUtilities::set($data, "postStatus"));
		$form->addDateTime("date", LANG_DATE, ArrayUtilities::set($data, "postDate"));
		$form->addVisualEditor("content", ArrayUtilities::set($data, "postContent"));
		$form->addHidden("id", ArrayUtilities::set($data, "postID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		$form->setDefaultElement("name");
		
		return $form->build();
	
	}

}
