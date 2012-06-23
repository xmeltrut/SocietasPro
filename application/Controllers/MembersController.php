<?php
/**
 * Members administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

namespace Controllers;

use Model\MembersModel;
use Model\MembersFieldsModel;
use Model\MembersGroupsModel;
use Framework\Core\Controller;
use Framework\Http\Request;
use Framework\Http\FrontController;
use Framework\Utilities\Pagination;
use Framework\Utilities\ArrayUtilities;
use Framework\Forms\FormBuilder;
use Framework\Core\TmpGateway;
use Framework\Language\Language;
use Framework\Wizards\ImportMembersWizard;
use Framework\Logging\AuditLogger;

class MembersController extends Controller {

	private $model;
	private $fieldsModel;
	private $groupsModel;
	
	function __construct () {
	
		parent::__construct();
		
		// create a members model
		//require_once("models/MembersModel.php");
		$this->model = new MembersModel();
		
		// create a members fields model
		//require_once("models/MembersFieldsModel.php");
		$this->fieldsModel = new MembersFieldsModel();
		
		// create a members groups model
		//require_once("models/MembersGroupsModel.php");
		$this->groupsModel = new MembersGroupsModel();
	
	}
	
	/**
	 * Create a new member
	 */
	public function create ($request) {
	
		// check for actions
		if ($request->set("action") == "create") {
			$this->model->write($_REQUEST);
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// output the page
		$this->engine->assign("form", $this->standardForm("create"));
		$this->engine->display("members/create.tpl");
	
	}
	
	/**
	 * Create a new members field
	 */
	public function createfield ($request) {
	
		// check for actions
		if ($request->set("action") == "create") {
			$this->fieldsModel->write($_REQUEST);
			$this->engine->setMessage($this->fieldsModel->getMessage());
		}
		
		// output the page
		$this->engine->assign("form", $this->fieldsForm("create"));
		$this->engine->display("members/createfield.tpl");
	
	}
	
	/**
	 * Create a new members group
	 */
	public function creategroup ($request) {
	
		// check for actions
		if ($request->set("action") == "create") {
			$this->groupsModel->write($_REQUEST);
			$this->engine->setMessage($this->groupsModel->getMessage());
		}
		
		// output the page
		$this->engine->assign("form", $this->groupsForm("create"));
		$this->engine->display("members/creategroup.tpl");
	
	}

	
	/**
	 * Export as CSV
	 */
	public function csv ($request) {
	
		// csv object
		$csv = new \CsvBuilder(LANG_MEMBERS);
		
		// get an array of members
		$members = $this->model->get();
		$fields = $this->fieldsModel->get();
		
		// begin output
		$headers = array(LANG_ID,LANG_EMAIL,LANG_FORENAME,LANG_SURNAME,LANG_PRIVILEGES,LANG_ADDRESS,LANG_NOTES);
		
		foreach ($fields as $field) {
			$headers[] = $field->fieldName;
		}
		
		$csv->addRow($headers);
		
		// loop through members
		foreach ($members as $member) {
		
			$data = array (
				$member->memberID,
				$member->memberEmail,
				$member->memberForename,
				$member->memberSurname,
				$this->model->getPrivilege($member->memberPrivileges),
				$member->memberAddress,
				$member->memberNotes
			);
			
			foreach ($member->getAllCustomData() as $custom) {
				$data[] = $custom;
			}
			
			$csv->addRow($data);
		
		}
		
		// log as an action in the audit trail
		AuditTrail::log(12);
		
		// output the result
		$csv->output();
	
	}
	
	/**
	 * Edit a member
	 */
	public function edit ($request) {
	
		// check for actions
		if ($request->set("action") == "edit") {
			$this->model->write($_REQUEST, FrontController::getParam(0));
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// get a member object
		$member = $this->model->getById(FrontController::getParam(0));
		if ($member === false) { throw new \HttpErrorException(404); }
		
		// build initial data array
		$defaults = $member->getAllData();
		foreach ($member->getAllCustomData() as $key => $val) {
			$defaults["custom".$key] = $val;
		}
		
		// output page
		$this->engine->assign("form", $this->standardForm("edit", $defaults));
		$this->engine->display("members/edit.tpl");
	
	}
	
	/**
	 * Edit a members field
	 */
	public function editfield ($request) {
	
		// check for actions
		if ($request->set("action") == "edit") {
			$this->fieldsModel->write($_REQUEST, \Framework\Http\FrontController::getParam(0));
			$this->engine->setMessage($this->fieldsModel->getMessage());
		}
		
		// output page
		$field = $this->fieldsModel->getById(\Framework\Http\FrontController::getParam(0));
		if ($field === false) { throw new \HttpErrorException(404); }
		
		$this->engine->assign("form", $this->fieldsForm("edit", $field->getAllData()));
		$this->engine->display("members/editfield.tpl");
	
	}
	
	/**
	 * Edit a members groups
	 */
	public function editgroup ($request) {
	
		// check for actions
		if ($request->set("action") == "edit") {
			$this->groupsModel->write($_REQUEST, FrontController::getParam(0));
			$this->engine->setMessage($this->groupsModel->getMessage());
		}
		
		// output page
		$group = $this->groupsModel->getById(FrontController::getParam(0));
		if ($group === false) { throw new \HttpErrorException(404); }
		
		$this->engine->assign("form", $this->groupsForm("edit", $group->getAllData()));
		$this->engine->display("members/editgroup.tpl");
	
	}
	
	/**
	 * Custom fields
	 */
	public function fields ($request) {
	
		// check for actions
		if ($request->set("action") == "mass") {
			if ($info = $this->determineMassAction()) {
				switch ($info["action"]) {
					case "delete":
						$this->fieldsModel->deleteById($info["ids"], 25);
						break;
				}
			}
			$this->engine->setMessage($this->fieldsModel->getMessage());
		}
		
		// output the page
		$fields = $this->fieldsModel->get();
		$this->engine->assign("fields", $fields);
		$this->engine->display("members/fields.tpl");
	
	}
	
	/**
	 * Form for members fields
	 *
	 * @param string $action Form variable
	 * @param array $data Default values
	 */
	private function fieldsForm ($action, $data = array()) {
	
		$form = new FormBuilder();
		$form->addInput("name", LANG_NAME, ArrayUtilities::set($data, "fieldName"));
		$form->addSelect("type", LANG_TYPE, $this->fieldsModel->getTypes(), ArrayUtilities::set($data, "fieldType"));
		$form->addTextArea("options", LANG_OPTIONS, ArrayUtilities::set($data, "fieldOptions"));
		$form->addHidden("id", ArrayUtilities::set($data, "fieldID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		$form->setDefaultElement("name");
		
		return $form->build();
	
	}
	
	/**
	 * Groups
	 */
	public function groups ($request) {
	
		// check for actions
		if ($request->set("action") == "mass") {
			if ($info = $this->determineMassAction()) {
				switch ($info["action"]) {
					case "delete":
						$this->groupsModel->deleteById($info["ids"], 25);
						break;
				}
			}
			$this->engine->setMessage($this->groupsModel->getMessage());
		}
		
		// output the page
		$groups = $this->groupsModel->get();
		$this->engine->assign("groups", $groups);
		$this->engine->display("members/groups.tpl");
	
	}
	
	/**
	 * Form for members groups
	 *
	 * @param string $action Form variable
	 * @param array $data Default values
	 */
	private function groupsForm ($action, $data = array()) {
	
		$form = new FormBuilder();
		$form->addInput("name", LANG_NAME, ArrayUtilities::set($data, "groupName"));
		$form->addHidden("id", ArrayUtilities::set($data, "fieldID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		$form->setDefaultElement("name");
		
		return $form->build();
	
	}
	
	/**
	 * Import members
	 */
	public function import ($request) {
	
		// build objects
		$form = new FormBuilder();
		$tmp = new TmpGateway();
		
		// check for actions
		if ($request->set("action") == "import") {
		
			// move file to a common location
			$fileHash = strtolower(md5($_FILES["upload"]["name"].microtime(true)));
			$fileLoca = $tmp->getPath()."/".$fileHash.".csv";
			move_uploaded_file($_FILES["upload"]["tmp_name"], $fileLoca);
			
			// read file
			ini_set('auto_detect_line_endings', true);
			$file = file($fileLoca);
			
			// create a wizard
			$wizard = new ImportMembersWizard($file);
			
			// get headers and build form
			$headers = $wizard->getColumnHeaders();
			$options = $wizard->getColumnOptions();
			
			foreach ($headers as $key => $val) {
				$form->addSelect("col".$key, $val, $options, $wizard->matchHeaderToColumn($val));
			}
			
			$form->addHidden("data", $fileHash);
			$form->addHidden("action", "import2");
			$form->addSubmit(LANG_IMPORT);
			
			// output page
			$this->engine->assign("form", $form->build());
			$this->engine->display("members/import2.tpl");
		
		} else {
		
			// check for actions
			if ($request->set("action") == "import2") {
		
				// get the data file
				$fileLoca = $tmp->getPath()."/".strSantiseFilename($_REQUEST["data"]).".csv";
				$file = file($fileLoca);
				
				// create a wizard
				$wizard = new \ImportMembersWizard($file);
				
				// create a map based on user's selections
				$map = array();
				
				foreach ($_REQUEST as $key => $val) {
					if (substr($key, 0, 3) == "col") {
						$map[$val] = intval(str_replace("col", "", $key));
					}
				}
				
				$result = $wizard->importUsingMap($map);
				$this->engine->setMessage($result);
			
			}
			
			$form->addFile("upload", LANG_CSV);
			$form->addHidden("action", "import");
			$form->addSubmit();
			
			// output page
			$this->engine->assign("form", $form->build());
			$this->engine->assign("is_writable", $tmp->isWritable());
			$this->engine->assign("not_writable", str_replace("%%DIR%%", $tmp->getPath(), Language::getContent("enable_tmp_dir")));
			$this->engine->display("members/import.tpl");
		
		}
	
	}
	
	/**
	 * Index page
	 */
	public function index ($request) {
	
		// check for actions
		if ($request->set("action") == "mass") {
			if ($info = $this->determineMassAction()) {
				switch ($info["action"]) {
					case "delete":
						$this->model->deleteById($info["ids"], 17);
						break;
				}
			}
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// gather variables for page
		$pageNum = Pagination::pageNum(\Framework\Http\FrontController::getParam(0));
		$totalPages = Pagination::totalPages($this->model->count());
		$members = $this->model->get($pageNum);
		
		// output the page
		$this->engine->assign("members", $members);
		$this->engine->assign("pageNum", $pageNum);
		$this->engine->assign("totalPages", $totalPages);
		$this->engine->display("members/index.tpl");
	
	}
	
	/**
	 * Create a standard form for editing members
	 *
	 * @param string $action Form variable
	 * @param array $data Default values
	 */
	private function standardForm ($action, $data = array()) {
	
		// add standard form elements
		$form = new FormBuilder();
		$form->addInput("email", LANG_EMAIL, ArrayUtilities::set($data, "memberEmail"));
		$form->addInput("forename", LANG_FORENAME, ArrayUtilities::set($data, "memberForename"));
		$form->addInput("surname", LANG_SURNAME, ArrayUtilities::set($data, "memberSurname"));
		$form->addSelect("privileges", LANG_PRIVILEGES, $this->model->getPrivileges(), ArrayUtilities::set($data, "memberPrivileges"));
		$form->addPassword("password", LANG_PASSWORD);
		$form->addTextArea("address", LANG_ADDRESS, ArrayUtilities::set($data, "memberAddress"));
		$form->addTextArea("notes", LANG_NOTES, ArrayUtilities::set($data, "memberNotes"));
		
		// add groups
		$groups = $this->groupsModel->get();
		for ($i = 0; $i < count($groups); $i++) {
			$group = $groups[$i];
			$form->addCheckbox("groups", LANG_GROUPS, $group->groupName, "123");
			$form->addCheckbox("groups", "", "Name of element", "123");
		}
		
		// add custom fields
		$fields = $this->fieldsModel->get();
		foreach ($fields as $field) {
			$fieldID = "custom".$field->fieldID;
			switch ($field->fieldType) {
				case "select":
					$form->addSelect($fieldID, $field->fieldName, $field->getOptions(), ArrayUtilities::set($data, $fieldID));
					break;
				case "textarea":
					$form->addTextArea($fieldID, $field->fieldName, ArrayUtilities::set($data, $fieldID));
					break;
				default:
					$form->addInput($fieldID, $field->fieldName, ArrayUtilities::set($data, $fieldID));
			}
		}
		
		// finish form
		$form->addHidden("id", ArrayUtilities::set($data, "memberID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		$form->setDefaultElement("email");
		
		return $form->build();
	
	}

}
