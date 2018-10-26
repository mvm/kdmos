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
    
    public function getSurveyId() {
        return $this->survey_id;
    }

    public function getDay() {
        return $this->day;
    }

    public function setDay($day) {
        $this->day = $day;
    }

    public function getStart() {
        return $this->start;
    }

    public function setStart($start) {
        $this->start = $start;
    }

    public function getEnd() {
        return $this->end;
    }

    public function setEnd($end) {
        $this->end = $end;
    }

    public function checkStartEnd() {
        // TODO
    }
}
?>