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

    public function getParticipated() {
        $currentUser = parent::authenticateUser();
        $surveys = $this->surveyMapper->findByParticipated($currentUser->getId());
        $result = array();

        foreach($surveys as $s) {
            array_push($result, array(
                "id" => $s->getId(),
                "title" => $s->getTitle(),
                "description" => $s->getDescription()
            ));
        }

        header($_SERVER["SERVER_PROTOCOL"] . " 200 Ok");
        header("Content-Type: application/json");
        echo(json_encode($result));
    }

    public function create($data) {
        $user = parent::authenticateUser();
        $errors = array();

        if(!$data) {
            $errors["data"] = "Can't parse data";
        }
        
        if(!isset($data->title)) {
            $errors["title"] = "Title not set";
        }
        
        if(!isset($data->description)) {
            $errors["description"] = "Description not set";
        }
        
        if(!isset($data->options)) {
            $errors["options"] = "Options not specified";
        }

        if($errors) {
            header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
            echo json_encode($errors);
            return;
        }

        $survey = new Survey(0, $data->title, $data->description, $user);
        $survey_id = $survey->newId();

        $options = array();
        foreach($data->options as $option) {
            $o = new Option();
            $o->setSurveyId($survey->getId());
            $o->setDay($option->day);
            $o->setStart($option->start);
            $o->setEnd($option->end);
            array_push($options, $o);
        }
        $survey->setOptions($options);

        try {
            $survey->checkIsValidForCreate();
            $this->surveyMapper->save($survey);
        } catch(ValidationException $ex) {
            $errors = $ex->getErrors();
        }

        if($errors) {
            header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
            echo json_encode($errors);
            return;
        }
        
        header($_SERVER["SERVER_PROTOCOL"] . " 201 Created");
    }
}

$surveyRest = new SurveyRest();
URIDispatcher::getInstance()
    ->map("GET", "/survey/created", array($surveyRest, "getCreated"))
    ->map("GET", "/survey/participated", array($surveyRest, "getParticipated"))
    ->map("POST", "/survey", array($surveyRest, "create"));

?>