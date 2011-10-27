<?php
/**
 * Members administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * Add privileges to say standard or admin member
 */

class MembersController extends BaseController implements iController {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Create a new member
	 */
	public function create () {
	
		// check for actions
		if (reqSet("action") == "create") {
			include_once("models/MembersModel.php");
			$membersModel = new MembersModel();
			$membersModel->create($_REQUEST["email"], $_REQUEST["forename"], $_REQUEST["surname"]);
			$this->engine->assign("msg", $membersModel->getMessage());
		}
		
		// output the page
		$this->engine->assign("form", $this->standardForm("create"));
		$this->engine->display("members/create.tpl");
	
	}
	
	/**
	 * Edit a member
	 */
	public function edit () {
	
		// get the current user's details
		$front = FrontController::getInstance();
		
		require_once("models/MembersModel.php");
		$membersModel = new MembersModel();
		$member = $membersModel->getMemberById($front->getParam(0));
		
		// check for actions
		if (reqSet("action") == "edit") {
			$member->setEmailAddress($_REQUEST["email"]);
			$member->setForename($_REQUEST["forename"]);
			$member->setSurname($_REQUEST["surname"]);
			$membersModel->save($member);
		}
		
		// output page
		$this->engine->assign("form", $this->standardForm("edit", $member->getAllData()));
		$this->engine->display("members/edit.tpl");
	
	}
	
	/**
	 * Index page
	 */
	public function index () {
	
		// create a members model
		include_once("models/MembersModel.php");
		$membersModel = new MembersModel();
		
		// check for actions
		if (reqSet("action") == "delete") {
			$membersModel->deleteById($_REQUEST["id"]);
		}
		
		// get a list of members
		$members = $membersModel->getMembers();
		
		// output the page
		$this->engine->assign("members", $members);
		$this->engine->display("members/index.tpl");
	
	}
	
	/**
	 * Create a standard form for editing members
	 *
	 * @param string $action Form variable
	 * @param array $data Default values
	 */
	private function standardForm ($action, $data = array()) {
	
		require_once("formbuilder.php");
		
		$form = new FormBuilder();
		$form->addInput("email", LANG_EMAIL, arrSet($data, "memberEmail"));
		$form->addInput("forename", LANG_FORENAME, arrSet($data, "memberForename"));
		$form->addInput("surname", LANG_SURNAME, arrSet($data, "memberSurname"));
		$form->addHidden("id", arrSet($data, "memberID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		
		return $form->build();
	
	}

}
