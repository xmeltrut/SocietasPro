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
	 * Create a new member
	 */
	public function create () {
	
		// check for actions
		if (varSet("action") == "create") {
			include_once("models/EventsModel.php");
			$eventsModel = new EventsModel();
			$eventsModel->create($_REQUEST["name"], $_REQUEST["date"]);
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
	 * Default page
	 */
	public function index () {
	
		include_once("models/EventsModel.php");
		$eventsModel = new EventsModel();
		$events = $eventsModel->getEvents();
		
		$this->engine->assign("events", $events);
		$this->engine->display("events/index.tpl");
	
	}

}
