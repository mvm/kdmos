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
    }

    public function list_participated() {

    }

    public function add() {
        if(!isset($this->currentUser)) {
            throw new Exception("Not in session. Adding posts requires login");
        }

        $survey = new Survey();
        
        if(isset($_POST["submit"])) {
            $survey_id = $survey->newId();
            $survey->setTitle($_POST["title"]);
            $survey->setDescription($_POST["description"]);
            $user = new User($this->currentUserId);
            $survey->setCreator($user);

            $options = array();
            $option_nums = split(" ", $_POST["num_dates"]);
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
                $this->view->redirect("users", "login");
            } catch(ValidationException $ex) {
                $errors = $ex->getErrors();
                $this->view->setVariable("errors", $errors);
            }
        }
        $this->view->setVariable("survey", $survey);
        $this->view->render("surveys", "add");
    }

    public function edit() {
        if(!isset($this->currentUser)) {
            throw new Exception("Not in session.");
        }

        if(!isset($_REQUEST["id"])) {
            throw new Exception("Id not specified.");
        }

        $survey = $this->surveyMapper->findById($_REQUEST["id"]);
        if($survey == NULL) {
            throw new Exception("Survey not found.");
        }
        $options = $this->optionMapper->findBySurvey($survey);
        $survey->setOptions($options);

        if(isset($_POST["submit"])) {
            $modified_dates = split(" ", $_POST["edit_dates"]);
            $del_opts = array();
            $mod_opts = array();
            
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
                $this->optionMapper->update($o);
            }
            $this->view->redirect("surveys", "list_created");
        } else {        
            $this->view->setVariable("survey", $survey);
            $this->view->render("surveys", "edit");
        }
    }

}

?>