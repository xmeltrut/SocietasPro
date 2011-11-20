<?php
/**
 * Blog administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

namespace admin;

class BlogController extends \BaseController implements \iController {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/BlogPostsModel.php");
		$this->model = new \BlogPostsModel();
	
	}
	
	/**
	 * Create a new blog post
	 */
	public function create () {
	
		// check actions
		if (reqSet("action") == "create") {
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
	public function edit () {
	
		// check for actions
		if (reqSet("action") == "edit") {
			$this->model->write($_REQUEST, \FrontController::getParam(0));
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// get the object
		$post = $this->model->getById(\FrontController::getParam(0));
		if ($post === false) { throw new \HttpErrorException(404); }
		
		// output page
		$this->engine->assign("form", $this->standardForm("edit", $post->getAllData()));
		$this->engine->display("blog/edit.tpl");
	
	}
	
	/**
	 * Default page
	 */
	public function index () {
	
		// check for actions
		if (reqSet("action") == "mass") {
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
		$pageNum = pageNum(\FrontController::getParam(0));
		$totalPages = totalPages($this->model->count());
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
	
		$form = new \FormBuilder();
		$form->addInput("name", LANG_NAME, arrSet($data, "postName"));
		$form->addInput("slug", LANG_URL, arrSet($data, "postSlug"));
		$form->addDateTime("date", LANG_DATE, arrSet($data, "postDate"));
		$form->addVisualEditor("content", arrSet($data, "postContent"));
		$form->addHidden("id", arrSet($data, "postID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		$form->setDefaultElement("name");
		
		return $form->build();
	
	}

}
