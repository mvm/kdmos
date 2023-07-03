<?php

require_once(__DIR__."/../model/Survey.php");
require_once(__DIR__."/../model/SurveyMapper.php");
require_once(__DIR__."/../model/OptionMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class SurveysController extends BaseController {
    private $surveyMapper;
    private $optionMapper;

    public function __construct() {
        parent::__construct();

        $this->surveyMapper = new SurveyMapper();
        $this->optionMapper = new OptionMapper();
        $this->view->setLayout("default");
    }

    public function list_created() {
        if(!isset($this->currentUser)) {
            $this->view->redirect("users", "login");
            return;
        }

        $surveys_created = $this->surveyMapper->findByCreator($this->currentUserId);
        $this->view->setVariable("edit", true);
        $this->view->setVariable("results", $surveys_created);
        $this->view->render("surveys", "showall");
    }

    public function list_participated() {
        if(!isset($this->currentUser)) {
            $this->view->redirect("users", "login");
            return;
        }
        $surveys_part = $this->surveyMapper->findByParticipated($this->currentUserId);
        $this->view->setVariable("edit", false);
        $this->view->setVariable("results", $surveys_part);
        $this->view->render("surveys", "showall");
    }

    public function added() {
        if(!isset($this->currentUser)) {
            $this->view->redirect("users","login");
            return;
        }

        $survey = new Survey();
        $survey->setId($_REQUEST["id"]);
        $this->view->setVariable("survey", $survey);
        $this->view->render("surveys", "added");
    }

    public function add() {
        if(!isset($this->currentUser)) {
            $this->view->redirect("users", "login");
            return;
        }

        $survey = new Survey();
        
        if(isset($_POST["submit"])) {
            $survey_id = $survey->newId();
            $survey->setTitle($_POST["title"]);
            $survey->setDescription($_POST["description"]);
            $user = new User($this->currentUserId);
            $survey->setCreator($user);

            $options = array();
            $option_nums = explode(" ", $_POST["num_dates"]);
            foreach($option_nums as $opt_i) {
                if($opt_i == "") {
                    continue;
                }
                $option = new Option();
                $option->setSurveyId($survey->getId());
                $option->setDay($_POST["date" . $opt_i . "_day"]);
                $option->setStart($_POST["date" . $opt_i . "_start"]);
                $option->setEnd($_POST["date" . $opt_i . "_end"]);
                array_push($options, $option);
            }

            $survey->setOptions($options);

            try {
                $survey->checkIsValidForCreate();

                $this->surveyMapper->save($survey);
                $this->view->redirect("surveys", "added", "id=" . $survey->getId());
            } catch(ValidationException $ex) {
                $errors = $ex->getErrors();
                $this->view->setVariable("errors", $errors);
            }
        } else {
            $this->view->setVariable("survey", $survey);
            $this->view->render("surveys", "add");
        }
    }

    public function edit() {
        if(!isset($this->currentUser)) {
            $this->view->redirect("users", "login");
            return;
        }

        if(!isset($_REQUEST["id"])) {
            throw new Exception("Id not specified.");
        }

        $survey = $this->surveyMapper->findById($_REQUEST["id"]);
        if($survey == NULL) {
            throw new Exception("Survey not found.");
        }
        
        if($survey->getCreator()->getId() != $this->currentUserId) {
            throw new Exception("Cannot edit a survey you don't own");
        }
        
        $options = $this->optionMapper->findBySurvey($survey);
        $survey->setOptions($options);

        if(isset($_POST["submit"])) {
            $errors = array();
            $survey->setTitle($_POST["title"]);
            $survey->setDescription($_POST["description"]);
            $this->surveyMapper->update($survey);
            
            $modified_dates = explode(" ", $_POST["edit_dates"]);
            $added_opts = explode(" ", $_POST["num_dates"]);
            $del_opts = array();
            $mod_opts = array();

            foreach($added_opts as $a) {
                if($a != NULL) {
                    $o = new Option(0, $survey->getId(), $_POST["date" . $a . "_day"], $_POST["date" . $a . "_start"], $_POST["date" . $a . "_end"]);
                    $this->optionMapper->save($o);
                }
            }
            
            foreach($modified_dates as $d) {
                if(isset($_POST["edit" . $d . "_day"])) {
                    $o = new Option($d, $survey->getId(), $_POST["edit" . $d . "_day"], $_POST["edit" . $d . "_start"], $_POST["edit" . $d . "_end"]);
                    array_push($mod_opts, $o);
                } else {
                    $o = new Option($d);
                    array_push($del_opts, $o);
                }
            }

            foreach($del_opts as $o) {
                $this->optionMapper->delete($o);
            }

            foreach($mod_opts as $o) {
                try {
                    $o->checkValid();
                    $this->optionMapper->update($o);
                } catch(ValidationException $e) {
                    $errors = $e->getErrors();
                    $this->view->setVariable("errors", $errors);
                }
            }
            
            if(sizeof($errors) > 0) {
                $this->view->setVariable("survey", $survey);
                $this->view->render("surveys", "edit");
            } else {
                $this->view->redirect("surveys", "list_created");
            }
        } else {        
            $this->view->setVariable("survey", $survey);
            $this->view->render("surveys", "edit");
        }
    }

}

?>