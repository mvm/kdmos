<?php
require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Option.php");
require_once(__DIR__."/../model/Survey.php");

class SurveyMapper {
    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function findByCreator($creatorid) {
        $stmt = $this->db->prepare("SELECT 
surveys.id, surveys.title, surveys.description,
users.id, users.name, users.surname, users.email, users.pass
FROM surveys JOIN users ON surveys.creator = users.id
WHERE surveys.creator_id = ?");
        $stmt->execute(array($creatorid));
        $surveys = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = array();

        foreach($surveys as $s) {
            $survey_creator = new User($s["users.id"], $s["users.name"], $s["users.surname"], $s["users.email"], $s["users.pass"]);
            $current_survey = new Survey($s["surveys.id"], $s["surveys.title"],
            $s["surveys.description"], $survey_creator);
            array_push($result, $current_survey);
        }
        
        return $result;
    }

    public function findById($survey_id) {
        $stmt = $this->db->prepare("SELECT surveys.id, surveys.title, surveys.description, users.id, users.name, users.surname, users.email, users.pass FROM surveys JOIN users ON surveys.creator = users.id WHERE surveys.id = ?");
        $stmt->execute(array($survey_id));
        $survey_row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($survey_row == NULL) {
            return NULL;
        }

        $creator = new User($survey_row["users.id"], $survey_row["users.name"], $survey_row["users.surname"], $survey_row["users.email"], $survey_row["users.pass"]);
        $survey = new Survey($survey_row["surveys.id"], $survey_row["surveys.title"], $survey_row["surveys.description"], $creator);
        return $survey;
    }

    public function save(Survey $survey) {
        $stmt = $this->db->prepare("INSERT INTO surveys(id, title, description, creator) VALUES (?, ?, ?, ?)");
        $stmt->execute(array($survey->getId(), $survey->getTitle(), $survey->getDescription(), $survey->getCreator()->getId()));

        foreach($survey->getOptions() as $option) {
            $stmt = $this->db->prepare("INSERT INTO options (id, survey_id, day, start, end) values (?,?,?,?,?)");
            $stmt->execute(array($option->getId(), $option->getSurveyId(), $option->getDay()->format("Y-m-d"), $option->getStart()->format("H:i"), $option->getEnd()->format("H:i")));
        }
        
        return $this->db->lastInsertId();
    }

    public function update(Survey $survey) {
        $stmt = $this->db->prepare("UPDATE surveys SET title=?, description=?, creator = ? WHERE id = ?");
        $stmt->execute(array($survey->getTitle(), $survey->getDescription(), $survey->getCreator()->getId(), $survey->getId()));
    }

    public function delete(Survey $survey) {
        $stmt = $this->db->prepare("DELETE FROM surveys WHERE id = ?");
        $stmt->execute($survey->getId());
    }
}

?>