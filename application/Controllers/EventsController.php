<?php
/**
 * Events administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

namespace Controllers;

use Model\EventsModel;
use Model\LocationsModel;
use Framework\Core\Controller;
use Framework\Utilities\Pagination;
use Framework\Utilities\ArrayUtilities;
use Framework\Forms\FormBuilder;
use Framework\Http\FrontController;

use Framework\Database\EntityManager;

class EventsController extends Controller {

	private $model;
	private $locationsModel;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		//require_once("models/EventsModel.php");
		$this->model = new EventsModel();
		
		// create a model
		//require_once("models/LocationsModel.php");
		$this->locationsModel = new LocationsModel();
	
	}
	
	/**
	 * Create a new event
	 */
	public function create ($request) {
	
		// check for actions
		if ($request->set("action") == "create") {
			$this->model->write($_REQUEST);
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// output the page
		$this->engine->assign("form", $this->standardForm("create"));
		$this->engine->display("events/create.tpl");
	
	}
	
	/**
	 * Create a new location
	 */
	public function createlocation ($request) {
	
		// check for actions
		if ($request->set("action") == "create") {
			$this->locationsModel->write($_REQUEST);
			$this->engine->setMessage($this->locationsModel->getMessage());
		}
		
		// output page
		$this->engine->assign("form", $this->locationsForm("create"));
		$this->engine->display("events/createlocation.tpl");
	
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
		$event = $this->model->getById(FrontController::getParam(0));
		if ($event === false) { throw new \Exceptions\HttpErrorException(404); }
		
		// output page
		$this->engine->assign("form", $this->standardForm("edit", $event->getAllData()));
		$this->engine->display("events/edit.tpl");
	
	}
	
	/**
	 * Edit a location
	 */
	public function editlocation ($request) {
	
		// check for actions
		if ($request->set("action") == "edit") {
			$this->locationsModel->write($_REQUEST, \Framework\Http\FrontController::getParam(0));
			$this->engine->setMessage($this->locationsModel->getMessage());
		}
		
		// get the object
		$location = $this->locationsModel->getById(\Framework\Http\FrontController::getParam(0));
		if ($location === false) { throw new \HttpErrorException(404); }
		
		// output page
		$this->engine->assign("form", $this->locationsForm("edit", $location->getAllData()));
		$this->engine->display("events/editlocation.tpl");
	
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
						$this->model->deleteById($info["ids"], 21);
						break;
				}
			}
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// gather page variables
		$pageNum = Pagination::pageNum(\Framework\Http\FrontController::getParam(0));
		$totalPages = Pagination::totalPages($this->model->count());
		
		// @todo Needs to implement pagination
		//$events = $this->model->get($pageNum);
		
		$em = EntityManager::getInstance();
		$events = $em->getRepository("Entities\Event")->findBy(array());
		
		// output the page
		$this->engine->assign("events", $events);
		$this->engine->assign("pageNum", $pageNum);
		$this->engine->assign("totalPages", $totalPages);
		$this->engine->display("events/index.tpl");
	
	}
	
	/**
	 * Show a list of locations
	 */
	public function locations ($request) {
	
		// check for actions
		if ($request->set("action") == "mass") {
			if ($info = $this->determineMassAction()) {
				switch ($info["action"]) {
					case "delete":
						$this->locationsModel->deleteById($info["ids"], 20);
						break;
				}
			}
			$this->engine->setMessage($this->locationsModel->getMessage());
		}
		
		// output page
		$locations = $this->locationsModel->get();
		$this->engine->assign("locations", $locations);
		$this->engine->display("events/locations.tpl");
	
	}
	
	/**
	 * Create a standard form for editing locations
	 *
	 * @param string $action Form variable
	 * @param array $data Default values
	 */
	private function locationsForm ($action, $data = array()) {
	
		$form = new FormBuilder();
		
		$form->addInput("name", LANG_NAME, ArrayUtilities::set($data, "locationName"));
		$form->addTextArea("description", LANG_DESCRIPTION, ArrayUtilities::set($data, "locationDescription"));
		$form->addHidden("id", ArrayUtilities::set($data, "locationID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		$form->setDefaultElement("name");
		
		return $form->build();
	
	}
	
	/**
	 * Create a standard form for editing events
	 *
	 * @param string $action Form variable
	 * @param array $data Default values
	 */
	private function standardForm ($action, $data = array()) {
	
		// create a form object
		$form = new FormBuilder();
		
		// create a location model
		$locationsModel = new LocationsModel();
		
		// build an array of locations
		$options = array();
		$options[0] = LANG_UNKNOWN;
		$locations = $locationsModel->get();
		
		foreach ($locations as $location) {
			$options[$location->locationID] = $location->locationName;
		}
		
		// build the form
		$form->addInput("name", LANG_NAME, ArrayUtilities::set($data, "eventName"));
		$form->addSelect("location", LANG_LOCATION, $options, ArrayUtilities::set($data, "eventLocation"));
		$form->addDateTime("date", LANG_DATE, ArrayUtilities::set($data, "eventDate"));
		$form->addTextArea("description", LANG_DESCRIPTION, ArrayUtilities::set($data, "eventDescription"));
		$form->addHidden("id", ArrayUtilities::set($data, "memberID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		$form->setDefaultElement("name");
		
		return $form->build();
	
	}


}
