<?php
/**
 * Members administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Reimplement are you sure check on forms
 */

class MembersController extends BaseController implements iController {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a members model
		require_once("models/MembersModel.php");
		$this->model = new MembersModel();
	
	}
	
	/**
	 * Create a new member
	 */
	public function create () {
	
		// check for actions
		if (reqSet("action") == "create") {
			$this->model->create($_REQUEST["email"], $_REQUEST["forename"], $_REQUEST["surname"], $_REQUEST["address"], $_REQUEST["notes"]);
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// output the page
		$this->engine->assign("form", $this->standardForm("create"));
		$this->engine->display("members/create.tpl");
	
	}
	
	/**
	 * Export as CSV
	 */
	public function csv () {
	
		// csv object
		require_once("classes/CsvBuilder.php");
		$csv = new CsvBuilder(LANG_MEMBERS);
		
		// get an array of members
		$members = $this->model->get();
		
		// begin output
		$csv->addRow(array(LANG_ID,LANG_EMAIL,LANG_FORENAME,LANG_SURNAME,LANG_PRIVILEGES,LANG_ADDRESS,LANG_NOTES));
		
		// loop through members
		foreach ($members as $member) {
			$data = array (
				$member->getData("memberID"),
				$member->getData("memberEmail"),
				$member->getData("memberForename"),
				$member->getData("memberSurname"),
				$this->model->getPrivilege($member->getData("memberPrivileges")),
				$member->getData("memberAddress"),
				$member->getData("memberNotes")
			);
			$csv->addRow($data);
		}
		
		// output the result
		$csv->output();
	
	}
	
	/**
	 * Edit a member
	 */
	public function edit () {
	
		// get the current user's details
		$front = FrontController::getInstance();
		$member = $this->model->getById($front->getParam(0));
		
		// check for actions
		if (reqSet("action") == "edit") {
			$member->setEmailAddress($_REQUEST["email"]);
			$member->setForename($_REQUEST["forename"]);
			$member->setSurname($_REQUEST["surname"]);
			$member->setPrivileges($_REQUEST["privileges"]);
			$member->setAddress($_REQUEST["address"]);
			$member->setNotes($_REQUEST["notes"]);
			$this->model->save($member);
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// output page
		$this->engine->assign("form", $this->standardForm("edit", $member->getAllData()));
		$this->engine->display("members/edit.tpl");
	
	}
	
	/**
	 * Index page
	 */
	public function index () {
	
		// check for actions
		if (reqSet("action") == "mass") {
			if ($info = $this->determineMassAction()) {
				switch ($info["action"]) {
					case "delete":
						$this->model->deleteById($info["ids"]);
						break;
				}
			}
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// get a list of members
		$members = $this->model->get();
		
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
	
		require_once("classes/FormBuilder.php");
		
		$form = new FormBuilder();
		$form->addInput("email", LANG_EMAIL, arrSet($data, "memberEmail"));
		$form->addInput("forename", LANG_FORENAME, arrSet($data, "memberForename"));
		$form->addInput("surname", LANG_SURNAME, arrSet($data, "memberSurname"));
		$form->addSelect("privileges", LANG_PRIVILEGES, $this->model->getPrivileges(), arrSet($data, "memberPrivileges"));
		$form->addTextArea("address", LANG_ADDRESS, arrSet($data, "memberAddress"));
		$form->addTextArea("notes", LANG_NOTES, arrSet($data, "memberNotes"));
		$form->addHidden("id", arrSet($data, "memberID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		
		return $form->build();
	
	}

}
