<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");
require_once(__DIR__."/../model/Vote.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Option.php");
require_once(__DIR__."/../model/Survey.php");
require_once(__DIR__."/../model/VoteMapper.php");
require_once(__DIR__."/../model/SurveyMapper.php");
require_once(__DIR__."/../controller/BaseController.php");

/**
* Class VotesController
*/

class VotesController extends BaseController {

	private $voteMapper;
	
	public function __construct() {
		parent::__construct();
		$this->voteMapper = new VoteMapper();
		$this->surveyMapper = new SurveyMapper();
		$this->view->setLayout("default");
	}
	
	/**
	* Action to show
	*/

	public function show(){
		if(!isset($this->currentUser)) {
			$this->view->render("users","login");
			return;
        }
		
		if(!isset($_REQUEST["survey_id"])){
			 throw new Exception(i18n("A survey id is mandatory"));
		}
		
		$survey_id = $_REQUEST["survey_id"];
		$votes = $this->voteMapper->findBySurveyId($survey_id);
        
		$votesByOption = array();
		foreach($votes as $vote){
			array_push($votesByOption, $vote);
		}
		$survey = $this->surveyMapper->findById($survey_id);
        if ($survey == NULL) {
            throw new Exception(i18n("No such survey with id: ").$survey_id);
        }

		$this->view->setVariable("survey", $survey);
		$this->view->setVariable("votes", $votesByOption);
		$this->view->render("votes","show");
	}
	
	/**
	* Action to add
	*/
	
	public function add(){
		if(!isset($this->currentUser)) {
			$this->view->render("users","login");
			return;
        }
		if(!isset($_REQUEST["survey_id"])){
			 throw new Exception(i18n("A survey id is mandatory"));
		}
		
		if(isset($_POST["submit"])) {
			
		}else{
		$survey_id = $_REQUEST["survey_id"];
		$options_survey = $this->voteMapper->findOptionsBySurveyId($survey_id);
		
		if ($options_survey == NULL) {
            throw new Exception(i18n("No such survey with id: ").$survey_id);
        }
		$options =array();
		foreach($options_survey as $option){
			array_push($options, $option);
		}
		$survey = $this->surveyMapper->findById($survey_id);
		$this->view->setVariable("survey", $survey);
		$this->view->setVariable("options", $options);
		$this->view->render("votes","add");
		}
	}
	
}