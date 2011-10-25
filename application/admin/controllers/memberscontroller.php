<?php
/**
 * Members administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
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
		if (varSet("action") == "create") {
			include_once("models/MembersModel.php");
			$membersModel = new MembersModel();
			$membersModel->create($_REQUEST["email"], $_REQUEST["forename"], $_REQUEST["surname"]);
			$this->engine->assign("msg", $membersModel->getMessage());
		}
		
		// build the form
		require("formbuilder.php");
		
		$form = new FormBuilder();
		$form->addInput("email", "Email address");
		$form->addInput("forename", "Forename");
		$form->addInput("surname", "Surname");
		$form->addHidden("action", "create");
		$form->addSubmit();
		
		// output the page
		$this->engine->assign("form", $form->build());
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
		if (varSet("action") == "edit") {
			$member->setEmailAddress($_REQUEST["email"]);
			$member->setForename($_REQUEST["forename"]);
			$member->setSurname($_REQUEST["surname"]);
			$membersModel->save($member);
		}
		
		// build the form
		require("formbuilder.php");
		
		$form = new FormBuilder();
		$form->addInput("email", "Email address", $member->getData("email"));
		$form->addInput("forename", "Forename", $member->getData("forename"));
		$form->addInput("surname", "Surname", $member->getData("surname"));
		$form->addHidden("id", $member->getData("ID"));
		$form->addHidden("action", "edit");
		$form->addSubmit();
		
		// output page
		$this->engine->assign("form", $form->build());
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
		if (varSet("action") == "delete") {
			$membersModel->delete($_REQUEST["id"]);
		}
		
		// get a list of members
		$members = $membersModel->getMembers();
		
		// output the page
		$this->engine->assign("members", $members);
		$this->engine->display("members/index.tpl");
	
	}

}
