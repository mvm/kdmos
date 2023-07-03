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
		/**
		* If survey has no votes, redirect to vote form, if there is a survey with the request id.
		*/
        if($votes == NULL) {
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
        }else{
        
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
	}
	
	/**
	* Action to add or edit if exists
	*/
	
	public function add(){
		if(!isset($this->currentUser)) {
			$this->view->render("users","login");
			return;
        }
		if(!isset($_REQUEST["survey_id"])){
			 throw new Exception(i18n("A survey id is mandatory"));
		}
		$survey_id = $_REQUEST["survey_id"];
		if(isset($_POST["submit"])) {
			$options_survey = $this->voteMapper->findOptionsBySurveyId($survey_id);
		
			if ($options_survey == NULL) {
            throw new Exception(i18n("No such survey with id: ").$survey_id);
			}
			
			
			$votes_separated = $_POST["all_votes"];
			$num=0;
			while($num<sizeof($options_survey)){
				if ($this->voteMapper->checkIfExists($_SESSION["currentuserid"],$options_survey[$num]->getId())){
					$vote = new Vote ($_SESSION["currentuserid"],$options_survey[$num]->getId(),$votes_separated[$num]);
					$this->voteMapper->update($vote);
					$num+=1;
				}else{
					$vote = new Vote ($_SESSION["currentuserid"],$options_survey[$num]->getId(),$votes_separated[$num]);
					$this->voteMapper->save($vote);
					$num+=1;
				}
			}
			$survey_id = $_REQUEST["survey_id"];
			$votes = $this->voteMapper->findBySurveyId($survey_id);

			if($votes == NULL) {
				throw new Exception("No votes in survey");
			}
        
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
			$this->view->redirect("votes","show","survey_id=".$survey->getId());
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