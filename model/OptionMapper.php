<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Survey.php");
require_once(__DIR__."/../model/Option.php");

class OptionMapper {
    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function findBySurvey(Survey $survey) {
        $stmt = $this->db->prepare("SELECT id, day, start, end  FROM options WHERE survey_id = ?");
        $stmt->execute(array($survey->getId()));
        $options_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $options = array();


        foreach($options_arr as $option_row) {
            $op = new Option($option_row["id"], 0, $option_row["day"], $option_row["start"], $option_row["end"]);
            array_push($options, $op);
        }
        return $options;
    }

    public function save(Option $option) {
        $stmt = $this->db->prepare("INSERT INTO options(survey_id, day, start, end) VALUES (?, ?, ?, ?)");
        $stmt->execute(array($option->getSurveyId(), $option->getDay()->format("Y-m-d"), $option->getStart()->format("H:i:s"), $option->getEnd()->format("H:i:s")));
        return $this->db->lastInsertId();
    }

    public function update(Option $option) {
        $stmt = $this->db->prepare("UPDATE options SET day=?, start=?, end=? WHERE id = ?");
        $stmt->execute(array($option->getDay()->format("Y-m-d"), $option->getStart()->format("H:i:s"), $option->getEnd()->format("H:i:s"), $option->getId()));
    }

    public function delete(Option $option) {
        $stmt = $this->db->prepare("DELETE FROM options WHERE id=?");
        $stmt->execute(array($option->getId()));
    }
}

?>