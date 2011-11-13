<?php
/**
 * Events administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

namespace admin;

class EventsController extends \BaseController implements \iController {

	private $instance;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/EventsModel.php");
		$this->model = new \EventsModel();
	
	}
	
	/**
	 * Create a new event
	 */
	public function create () {
	
		// check for actions
		if (reqSet("action") == "create") {
			$this->model->write($_REQUEST);
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// output the page
		$this->engine->assign("form", $this->standardForm("create"));
		$this->engine->display("events/create.tpl");
	
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
		$event = $this->model->getById(\FrontController::getParam(0));
		if ($event === false) { throw new \HttpErrorException(404); }
		
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
						$this->model->deleteById($info["ids"], 21);
						break;
				}
			}
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// gather page variables
		$pageNum = \FrontController::getParam(0);
		$totalPages = totalPages($this->model->count());
		$events = $this->model->get($pageNum);
		
		// output the page
		$this->engine->assign("events", $events);
		$this->engine->assign("totalPages", $totalPages);
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
		$form = new \FormBuilder();
		
		// create a location model
		include_once("models/LocationsModel.php");
		$locationsModel = new \LocationsModel();
		
		// build an array of locations
		$options = array();
		$options[0] = LANG_UNKNOWN;
		$locations = $locationsModel->get();
		
		foreach ($locations as $location) {
			$options[$location->locationID] = $location->locationName;
		}
		
		// build the form
		$form->addInput("name", LANG_NAME, arrSet($data, "eventName"));
		$form->addSelect("location", LANG_LOCATION, $options, arrSet($data, "eventLocation"));
		$form->addDateTime("date", LANG_DATE, arrSet($data, "eventDate"));
		$form->addTextArea("description", LANG_DESCRIPTION, arrSet($data, "eventDescription"));
		$form->addHidden("id", arrSet($data, "memberID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		$form->setDefaultElement("name");
		
		return $form->build();
	
	}


}
