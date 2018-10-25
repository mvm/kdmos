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
        $this->view->render("surveys", "add");
    }

    public function edit() {

    }

    public function delete() {
        
    }
}

?>