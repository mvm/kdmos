<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Option.php");

class OptionMapper {
    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function findBySurvey($survey_id) {
        $stmt = $this->db->prepare("SELECT * FROM options WHERE survey_id = ?");
        $stmt->execute(array($survey_id));
        $options_arr = $stmt->fetch(PDO::FETCH_ASSOC);
        $options = array();
        
        foreach($options_arr as $option_row) {
            $op = new Option($option_row["id"], $option_row["day"], $option_row["start"], $option_row["end"]);
            array_push($options, $op);
        }
        return $options;
    }

    public function save(Option $option) {
        $stmt = $this->db->prepare("INSERT INTO options(survey_id, day, start, end) VALUES (?, ?, ?, ?)");
        $stmt->execute(array($option->getSurveyId(), $option->getDay(), $option->getStart(), $option->getEnd()));
        return $this->db->lastInsertId();
    }

    public function update(Option $option) {
        $stmt = $this->db->prepare("UPDATE options SET survey_id=?, day=?, start=?, end=? WHERE id = ?");
        $stmt->execute(array($option->getSurveyId(), $option->getDay(), $option->getStart(), $option->getEnd(), $option->getId()));
    }

    public function delete(Option $option) {
        $stmt = $this->db->prepare("DELETE FROM options WHERE id=?");
        $stmt->execute(array($option->getId()));
    }
}

?>