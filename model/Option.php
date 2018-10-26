<?php

class Option {
    private $id, $survey_id, $day, $start, $end;

    public function __construct($id = NULL, $survey_id = NULL, $day = NULL, $start = NULL, $end = NULL) {
        $this->id = $id;
        $this->survey_id = $survey_id;
        $this->day = $day;
        $this->start = $start;
        $this->end = $end;
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
        $this->day = date_create_from_format("d-m-Y", $day);
    }

    public function getStart() {
        return $this->start;
    }

    public function setStart($start) {
        $this->start = date_create_from_format("H:i",$start);
    }

    public function getEnd() {
        return $this->end;
    }

    public function setEnd($end) {
        $this->end = date_create_from_format("H:i", $end);
    }

    public function checkStartEnd() {
        // TODO
    }
}
?>