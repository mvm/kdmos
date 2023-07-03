<?php

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/Survey.php");
require_once(__DIR__."/../model/SurveyMapper.php");
require_once(__DIR__."/../model/Option.php");
require_once(__DIR__."/../model/OptionMapper.php");

require_once(__DIR__."/BaseRest.php");

class SurveyRest extends BaseRest {
    private $surveyMapper;
    private $optionMapper;

    public function __construct() {
        parent::__construct();

        $this->surveyMapper = new SurveyMapper();
        $this->optionMapper = new OptionMapper();
    }

    public function getCreated() {
        $currentUser = parent::authenticateUser();
        $surveys = $this->surveyMapper->findByCreator($currentUser->getId());
        $result = array();

        foreach($surveys as $s) {
            array_push($result, array(
                "id" => $s->getId(),
                "title" => $s->getTitle(),
                "description" => $s->getDescription(),
                "creator_id" => $s->getCreator()->getId()
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
                "description" => $s->getDescription(),
                "creator_id" => $s->getCreator()->getId()
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
            header("Content-Type: application/json");
            echo json_encode($errors);
            return;
        }
        
        header($_SERVER["SERVER_PROTOCOL"] . " 201 Created");
    }

    public function getEdit($id=NULL) {
        $user = parent::authenticateUser();

        if($id == NULL) {
            header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
            header("Content-Type: application/json");
            echo json_encode( array("id" => "No id provided") );
            return;
        }
        
        $survey = $this->surveyMapper->findById($id);
        if($survey->getCreator()->getId() != $user->getId()) {
            header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
            header("Content-Type: application/json");
            echo json_encode( array("creator" => "User did not create survey") );
            return;
        }
        
        $result = array();

        $result["id"] = $survey->getId();
        $result["title"] = $survey->getTitle();
        $result["description"] = $survey->getDescription();
        $result["creator_id"] = $survey->getCreator()->getId();
        $result["options"] = array();

        $survey->setOptions($this->optionMapper->findBySurvey($survey));

        foreach($survey->getOptions() as $option) {
            $opt_array = array();
            $opt_array["id"] = $option->getId();
            $opt_array["day"] = $option->getDay()->format("Y-m-d");
            $opt_array["start"] = $option->getStart()->format("H:i:s");
            $opt_array["end"] = $option->getEnd()->format("H:i:s");
            array_push($result["options"], $opt_array);
        }

        header($_SERVER["SERVER_PROTOCOL"] . " 200 Ok");
        header("Content-Type: application/json");
        echo json_encode( $result );
        return;
    }

    public function putEdit($id = NULL, $data = NULL) {
        $user = parent::authenticateUser();
        $errors = array();

        if($id == NULL || $data == NULL) {
            $errors["data"] = "Data not provided";
        }

        if($errors) {
            goto errors;
        }

        $s = $this->surveyMapper->findById($id);
        if($s->getCreator()->getId() != $user->getId()) {
            $errors["creator"] = "User is not creator of survey";
        }

        if(!isset($data->title)) {
            $errors["title"] = "Title not specified";
        }

        if(!isset($data->description)) {
            $errors["description"] = "Description not specified";
        }

        if(!isset($data->deleted))
            $errors["deleted"] = "Deleted options not specified";
        if(!isset($data->edited))
            $errors["edited"] = "Edited options not specified";
        if(!isset($data->new))
            $errors["new"] = "New options not specified";
        
        if($errors) {
            goto errors;
        }

        $s->setTitle($data->title);
        $s->setDescription($data->description);

        try {
            $s->checkIsValidForUpdate();
            $this->surveyMapper->update($s);
        } catch(ValidationException $e) {
            $errors = $e->getErrors();
            goto errors;
        }

        foreach($data->deleted as $opt_id) {
            $opt = new Option($opt_id);
            $this->optionMapper->delete($opt);
        }

        foreach($data->edited as $opt_arr) {
            $opt = new Option($opt_arr->id, $s->getId(),
            $opt_arr->day, $opt_arr->start, $opt_arr->end);

            try {
                $opt->checkValid();
                $this->optionMapper->update($opt);
            } catch(ValidationException $e) {
                $errors = $e->getErrors();
                goto errors;
            }
        }

        foreach($data->new as $opt_arr) {
            $opt = new Option(0, $s->getId(),
            $opt_arr->day, $opt_arr->start, $opt_arr->end);
            try {
                $opt->checkValid();
                $this->optionMapper->save($opt);
            } catch(ValidationException $e) {
                $errors = $e->getErrors();
                goto errors;
            }
        }
        
        header($_SERVER["SERVER_PROTOCOL"] . " 200 Ok");
        return;
      errors:
        header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
        header("Content-Type: application/json");
        echo json_encode($errors);
    }
}

$surveyRest = new SurveyRest();
URIDispatcher::getInstance()
    ->map("GET", "/survey/created", array($surveyRest, "getCreated"))
    ->map("GET", "/survey/participated", array($surveyRest, "getParticipated"))
    ->map("POST", "/survey", array($surveyRest, "create"))
    ->map("GET", "/survey/$1", array($surveyRest, "getEdit"))
    ->map("PUT", "/survey/$1", array($surveyRest, "putEdit"));

?>