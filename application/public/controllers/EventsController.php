<?php
/**
 * Displays events
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Public
 */

namespace publica;

class EventsController extends \BaseController implements \iController {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/EventsModel.php");
		$this->model = new \EventsModel();
	
	}
	
	public function calendar () {
	
		// initialise variables
		$days = array();
		$column = 1;
		
		// get the requested date
		if (\FrontController::getParam(0)) {
			$year  = \FrontController::getParam(0);
			$month = \FrontController::getParam(1);
		} else {
			$year  = date("Y");
			$month = date("m");
		}
		
		// what month are we looking at?
		if (!$t = strtotime("1 " . date('F', mktime(0,0,0,intval($month),1)) . " " . $year)) {
			throw new \HttpErrorException(404);
		}
		
		// build variables
		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, date("n", $t), date("Y", $t));
		$firstDayOfMonth = (intval(date("N", strtotime($t))) - 1);
		$previousMonth = ($t - 1000000);
		$nextMonth = ($t + 4000000);
		
		// calculate closing days
		$daysSoFar = ($daysInMonth + ($firstDayOfMonth - 1));
		$closingDays = ($daysSoFar == 28) ? 0 : (35 - $daysSoFar);
		
		// get an array of events
		for ($i = (2 - $firstDayOfMonth); $i <= ($daysInMonth + $closingDays); $i++) {
		
			// calculate variables
			if ($column == 1) {
				$colPosition = -1;
			} elseif ($column == 7) {
				$colPosition = 1;
			} else {
				$colPosition = 0;
			}
			
			// get events
			if ($i > 0 && $i <= $daysInMonth) {
				$events = $this->model->getByDate(date("Ym",$t).sprintf("%02s",$i));
				$placeholder = false;
			} else {
				$events = null;
				$placeholder = true;
			}
			
			// add item to array
			$days[$i] = array (
				"position" => $colPosition,
				"placeholder" => $placeholder,
				"events" => $events
			);
			
			// increment column
			$column++;
			$column = ($column > 7) ? 1 : $column;
		
		}
		
		// output page
		$this->engine->assign("days", $days);
		$this->engine->assign("priorDays", ($firstDayOfMonth - 1));
		$this->engine->assign("currentMonthName", date("F Y", $t));
		$this->engine->assign("previousMonthLink", date("Y/m", $previousMonth));
		$this->engine->assign("previousMonthName", date("F Y", $previousMonth));
		$this->engine->assign("nextMonthLink", date("Y/m", $nextMonth));
		$this->engine->assign("nextMonthName", date("F Y", $nextMonth));
		$this->engine->display("calendar.tpl");
	
	}
	
	public function details () {
	
		// get blog post
		$event = $this->model->getById(\FrontController::getParam(0));
		if ($event === false) { throw new \HttpErrorException(404); }
		
		// output page
		$this->engine->assign("event", $event);
		$this->engine->display("eventDetails.tpl");
	
	}
	
	public function feed () {
	
		// build channel variables
		$title = \Configuration::get("group_name")." ".LANG_EVENTS;
		$description = LANG_EVENTS;
		$link = \Configuration::getUrl()."/public/events";
		
		// create an rss object
		$rss = new \RssBuilder($title, $description, $link);
		
		// loop through events
		$events = $this->model->get();
		foreach ($events as $event) {
			$rss->addElement($event->eventName, $event->eventDescription, $link."/".$event->eventID, $event->eventDate);
		}
		
		// and output
		$rss->output();
	
	}
	
	public function index () {
	
		// get events
		$events = $this->model->get();
		
		// output page
		$this->engine->assign("events", $events);
		$this->engine->display("events.tpl");
	
	}

}
