<?php
/**
 * Events administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Implement cloning
 */

class EventsController extends BaseController implements iController {

	private $instance;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/EventsModel.php");
		$this->model = new EventsModel();
	
	}
	
	/**
	 * Create a new event
	 */
	public function create () {
	
		// check for actions
		if (reqSet("action") == "create") {
			$this->model->create($_REQUEST["name"], $_REQUEST["location"], $_REQUEST["date"], $_REQUEST["description"]);
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// output the page
		$this->engine->assign("form", $this->standardForm("create"));
		$this->engine->display("events/create.tpl");
	
	}
	
	/**
	 * Edit an event
	 */
	public function edit () {
	
		// get the current user's details
		$front = FrontController::getInstance();
		$event = $this->model->getById($front->getParam(0));
		
		// check for actions
		if (reqSet("action") == "edit") {
			$event->setName($_REQUEST["name"]);
			$event->setLocation($_REQUEST["location"]);
			$event->setDateByArray($_REQUEST["date"]);
			$event->setDescription($_REQUEST["description"]);
			$this->model->save($event);
		}
		
		// output page
		$this->engine->assign("form", $this->standardForm("edit", $event->getAllData()));
		$this->engine->display("events/edit.tpl");
	
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
		
		$events = $this->model->get();
		
		$this->engine->assign("events", $events);
		$this->engine->display("events/index.tpl");
	
	}
	
	/**
	 * Create a standard form for editing events
	 *
	 * @param string $action Form variable
	 * @param array $data Default values
	 */
	private function standardForm ($action, $data = array()) {
	
		// create a form object
		require_once("classes/FormBuilder.php");
		$form = new FormBuilder();
		
		// create a location model
		include_once("models/LocationsModel.php");
		$locationsModel = new LocationsModel();
		
		// build an array of locations
		$options = array();
		$options[0] = LANG_UNKNOWN;
		$locations = $locationsModel->get();
		
		foreach ($locations as $location) {
			$options[$location->getData("locationID")] = $location->getData("locationName");
		}
		
		// build the form
		$form->addInput("name", LANG_NAME, arrSet($data, "eventName"));
		$form->addSelect("location", LANG_LOCATION, $options, arrSet($data, "eventLocation"));
		$form->addDateTime("date", LANG_DATE, arrSet($data, "eventDate"));
		$form->addTextArea("description", LANG_DESCRIPTION, arrSet($data, "eventDescription"));
		$form->addHidden("id", arrSet($data, "memberID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		
		return $form->build();
	
	}


}
