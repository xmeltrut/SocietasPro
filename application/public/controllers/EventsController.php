<?php
/**
 * Displays events
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Public
 */

class EventsController extends BaseController implements iController {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/EventsModel.php");
		$this->model = new EventsModel();
	
	}
	
	public function details () {
	
		// get blog post
		$event = $this->model->getById(FrontController::getParam(0));
		
		// output page
		$this->engine->assign("event", $event);
		$this->engine->display("eventDetails.tpl");
	
	}
	
	public function index () {
	
		// get events
		$events = $this->model->get();
		
		// output page
		$this->engine->assign("events", $events);
		$this->engine->display("events.tpl");
	
	}

}
