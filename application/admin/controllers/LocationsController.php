<?php
/**
 * Event locations administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

class LocationsController extends BaseController implements iController {

	private $instance;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/LocationsModel.php");
		$this->model = new LocationsModel();
	
	}
	
	/**
	 * Create a new location
	 */
	public function create () {
	
		// check for actions
		if (reqSet("action") == "create") {
			$this->model->create($_REQUEST["name"], $_REQUEST["description"]);
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// output page
		$this->engine->assign("form", $this->standardForm("create"));
		$this->engine->display("locations/create.tpl");
	
	}
	
	public function index () {
	
		$locations = $this->model->get();
		$this->engine->assign("locations", $locations);
		$this->engine->display("locations/index.tpl");
	
	}
	
	/**
	 * Create a standard form for editing events
	 *
	 * @param string $action Form variable
	 * @param array $data Default values
	 */
	private function standardForm ($action, $data = array()) {
	
		require_once("classes/FormBuilder.php");
		
		$form = new FormBuilder();
		
		$form->addInput("name", LANG_NAME, arrSet($data, "locationName"));
		$form->addTextArea("description", LANG_DESCRIPTION, arrSet($data, "locationDescription"));
		$form->addHidden("id", arrSet($data, "locationID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		
		return $form->build();
	
	}

}
