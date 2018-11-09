<?php

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/Survey.php");
require_once(__DIR__."/../model/SurveyMapper.php");

require_once(__DIR__."/BaseRest.php");

class SurveyRest extends BaseRest {
    private $surveyMapper;

    public function __construct() {
        parent::__construct();

        $this->surveyMapper = new SurveyMapper();
    }

    public function getCreated() {
        $currentUser = parent::authenticateUser();
        $surveys = $this->surveyMapper->findByCreator($currentUser->getId());
        $result = array();

        foreach($surveys as $s) {
            array_push($result, array(
                "id" => $s->getId(),
                "title" => $s->getTitle(),
                "description" => $s->getDescription()
            ));
        }

        header($_SERVER['SERVER_PROTOCOL'] . " 200 Ok");
        header("Content-Type: application/json");
        echo(json_encode($result));
    }
}

$surveyRest = new SurveyRest();
URIDispatcher::getInstance()
    ->map("GET", "/survey/created", array($surveyRest, "getCreated"));

?>