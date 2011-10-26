<?php
/**
 * Events administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

class EventsController extends BaseController implements iController {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Create a new event
	 */
	public function create () {
	
		// check for actions
		if (reqSet("action") == "create") {
			include_once("models/EventsModel.php");
			$eventsModel = new EventsModel();
			$eventsModel->create($_REQUEST["name"], $_REQUEST["date"], $_REQUEST["description"]);
			$this->engine->assign("msg", $eventsModel->getMessage());
		}
		
		// build the form
		require("formbuilder.php");
		
		$form = new FormBuilder();
		$form->addInput("name", "Name");
		$form->addDateTime("date", "Date");
		$form->addTextArea("description", "Description");
		$form->addHidden("action", "create");
		$form->addSubmit();
		
		// output the page
		$this->engine->assign("form", $form->build());
		$this->engine->display("events/create.tpl");
	
	}
	
	/**
	 * Edit an event
	 */
	public function edit () {
	
		// get the current user's details
		$front = FrontController::getInstance();
		
		require_once("models/EventsModel.php");
		$eventsModel = new EventsModel();
		$event = $eventsModel->getEventById($front->getParam(0));
		
		// check for actions
		if (reqSet("action") == "edit") {
			$event->setName($_REQUEST["name"]);
			$event->setDateByArray($_REQUEST["date"]);
			$event->setDescription($_REQUEST["description"]);
			$eventsModel->save($event);
		}
		
		// output page
		$this->engine->assign("form", $this->standardForm("edit", $event->getAllData()));
		$this->engine->display("events/edit.tpl");
	
	}
	
	/**
	 * Default page
	 */
	public function index () {
	
		include_once("models/EventsModel.php");
		$eventsModel = new EventsModel();
		
		// check for actions
		if (reqSet("action") == "delete") {
			$eventsModel->delete($_REQUEST["id"]);
		}
		
		$events = $eventsModel->getEvents();
		
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
	
		require_once("formbuilder.php");
		
		$form = new FormBuilder();
		
		$form->addInput("name", "Name", arrSet($data, "eventName"));
		$form->addDateTime("date", "Date", arrSet($data, "eventDate"));
		$form->addTextArea("description", "Description", arrSet($data, "eventDescription"));
		$form->addHidden("id", arrSet($data, "memberID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		
		return $form->build();
	
	}


}
