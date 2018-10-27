<?php

class Option {
    private $id, $survey_id, $day, $start, $end;

    public function __construct($id = NULL, $survey_id = NULL, $day = NULL, $start = NULL, $end = NULL) {
        $this->id = $id;
        $this->survey_id = $survey_id;
        $this->day = date_create_from_format("Y-m-d", $day);
        $this->start = date_create_from_format("H:i:s",$start);
        $this->end = date_create_from_format("H:i:s", $end);
    }

    public function getId() {
        return $this->id;
    }

    public function newId() {
        $this->id = rand();
        return $this->id;
    }

    public function setSurveyId($survey_id) {
        $this->survey_id = $survey_id;
    }
    
    public function getSurveyId() {
        return $this->survey_id;
    }

    public function getDay() {
        return $this->day;
    }

    public function setDay($day) {
        $this->day = date_create_from_format("Y-m-d", $day);
    }

    public function getStart() {
        return $this->start;
    }

    public function setStart($start) {
        $this->start = date_create_from_format("H:i:s",$start);
    }

    public function getEnd() {
        return $this->end;
    }

    public function setEnd($end) {
        $this->end = date_create_from_format("H:i:s", $end);
    }

    public function checkValid() {
        $errors = array();
        if($this->start > $this->end) {
            $errors["startEnd"] = "Start cannot be after end";
        }
        if(sizeof($errors) > 0) {
            throw new ValidationException($errors, "option not valid");
        }
    }
}
?>