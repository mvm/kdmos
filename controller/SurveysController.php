<?php

require_once(__DIR__."/../model/Survey.php");
require_once(__DIR__."/../model/SurveyMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class SurveysController extends BaseController {
    private $surveyMapper;

    public function __construct() {
        parent::__construct();

        $this->surveyMapper = new SurveyMapper();
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

    }

    public function delete() {
        if(!isset($this->currentUser)) {
            throw new Exception("Not in session. Deleting posts requires login");
        }

        if(!isset($_GET["id"])) {
            throw new Exception("Survey id needed");
        }

        $survey_id = $_REQUEST["id"];
        $survey = $this->surveyMapper->findById($survey_id);
        if($survey == NULL) {
            throw new Exception("Survey with id " . $survey_id . " not found");
        }

        $this->surveyMapper->delete($survey);
        $this->view->redirect("surveys", "list_created");
    }
}

?>