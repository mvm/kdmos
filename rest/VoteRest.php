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
		$options = $this->voteMapper->findOptionsBySurveyId($survey_id);
		$survey = $this->surveyMapper->findById($survey_id);
		$result = array();
		if ($currentUser == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("You must be logged to see the survey");
			return;
		}
		if ($survey == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Survey with id ".$survey_id." not found");
			return;
		}
		foreach($options as $hueco){
				$option = array();
				$option["option_id"] = $hueco->getId();
				$option["day"] = $hueco->getDay()->format("Y-m-d");
				$option["start"] = $hueco->getStart()->format("H:i:s");
				$option["end"] = $hueco->getEnd()->format("H:i:s");
				$votos_opcion = array();
				$total = 0;
				foreach($votes as $vote) {
					if($hueco->getId() == $vote->getOptionId()->getId()){
						$voto_individual = array();
						$user = array();
						$user["user_id"] = $vote->getUserId()->getId();
						$user["name"] = $vote->getUserId()->getName();
						$user["surname"] = $vote->getUserId()->getSurname();
						$user["email"] = $vote->getUserId()->getEmail();
						$user["pass"] = $vote->getUserId()->getPass();	
						$voto_individual["user"] = $user;
						$voto_individual["vote"] = $vote->getVote();
						if ($vote->getVote() == "Y"){$total = $total + 1;}
						array_push($votos_opcion, $voto_individual);
					}
			}
			array_push($result, array(
					"hueco" => $option,
					"votos_opcion" => $votos_opcion,
					"total" => $total
				));
		}
		header($_SERVER["SERVER_PROTOCOL"] . " 200 Ok");
        header("Content-Type: application/json");
        echo(json_encode($result));
	}
	
	/**
	* Action to add or update votes
	*/
	
public function addVotes($survey_id = NULL, $data = NULL){
		$currentUser = parent::authenticateUser();
		
		$options_survey= $this->voteMapper->findOptionsBySurveyId($survey_id);
		if ($options_survey == NULL) {
			header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
			echo("Survey with id ".$survey_id." not found");
			return;
		}
		$num=0;
		$creados = false;
		while($num < sizeof($options_survey)){
					$vote = new Vote ($currentUser->getId(),$options_survey[$num]->getId(),$data[$num]);
					$num+=1;
					if ($this->voteMapper->checkIfExists($vote->getUserId(),$vote->getOptionId())){
						$this->voteMapper->update($vote);
					}else{
						$this->voteMapper->save($vote);
						$creados = true;
					}
        }
		if ($creados){
			header($_SERVER["SERVER_PROTOCOL"] . " 201 Created");
		}else{
			header($_SERVER["SERVER_PROTOCOL"] . " 200 Ok");
		}
    }
}


// URI-MAPPING for this Rest endpoint
$votesRest = new VoteRest();
URIDispatcher::getInstance()
->map("GET",	"/votes/$1", array($votesRest,"showVotes"))
->map("PUT",	"/votes/$1", array($votesRest,"addVotes"));

