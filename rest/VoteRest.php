<?php

require_once(__DIR__."/../model/User.php");

require_once(__DIR__."/../model/Survey.php");
require_once(__DIR__."/../model/SurveyMapper.php");

require_once(__DIR__."/../model/Option.php");

require_once(__DIR__."/../model/Vote.php");
require_once(__DIR__."/../model/VoteMapper.php");

require_once(__DIR__."/BaseRest.php");

/**
* Class VoteRest
*/

class VoteRest extends BaseRest {
	private $voteMapper;

	public function __construct() {
		parent::__construct();

		$this->voteMapper = new VoteMapper();
		$this->surveyMapper = new SurveyMapper();
	}

	/**
	* Action to show survey status
	*/
	
	public function showVotes($survey_id){
		$currentUser = parent::authenticateUser();
		
		$votes = $this->voteMapper->findBySurveyId($survey_id);
		$survey = $this->surveyMapper->findById($survey_id);
		if ($survey == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Survey with id ".$survey_id." not found");
			return;
		}
		header($_SERVER["SERVER_PROTOCOL"] . " 200 Ok");
        header("Content-Type: application/json");
        echo(json_encode($votes));
	}
	
	public function addVotes($survey_id, $data){
		$currentUser = parent::authenticateUser();
		
		$options_survey= $this->voteMapper->findOptionsBySurveyId($survey_id);
		if ($options_survey == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Survey with id ".$survey_id." not found");
			return;
		}
		$num=0;
		while($num<sizeof($options_survey)){
					$vote = new Vote ($currentUser,$options_survey[$num]->getId(),$data[$num]);
					$num+=1;
					header($_SERVER["SERVER_PROTOCOL"] . " 201 Created");
					header("Content-Type: application/json");
					echo(json_encode($vote));
        }
    }
}


// URI-MAPPING for this Rest endpoint
$votesRest = new VoteRest();
URIDispatcher::getInstance()
->map("GET",	"/votes/$1", array($votesRest,"showVotes"))
->map("PUT", "/votes/$1/$2", array($votesRest,"addVotes"));

