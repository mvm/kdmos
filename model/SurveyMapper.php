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

    public function findByParticipated($userid) {
        $stmt = $this->db->prepare("select distinct surveys.* from options join votes on votes.option_id = options.id join surveys on options.survey_id = surveys.id where votes.user_id = ?");
        $stmt->execute(array($userid));
        $surveys = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = array();

        foreach($surveys as $s) {
            $survey_creator = new User($userid);
            $current_survey = new Survey($s["id"], $s["title"],
            $s["description"], $survey_creator);
            array_push($result, $current_survey);
        }
        
        return $result;
    }

    public function findByCreator($creatorid) {
        $stmt = $this->db->prepare("SELECT 
surveys.id as survey_id, surveys.title, surveys.description,
users.id, users.name, users.surname, users.email, users.pass
FROM surveys JOIN users ON surveys.creator = users.id
WHERE surveys.creator = ?");
        $stmt->execute(array($creatorid));
        $surveys = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = array();

        foreach($surveys as $s) {
            $survey_creator = new User($s["id"], $s["name"], $s["surname"], $s["email"], $s["pass"]);
            $current_survey = new Survey($s["survey_id"], $s["title"],
            $s["description"], $survey_creator);
            array_push($result, $current_survey);
        }
        
        return $result;
    }

    public function findById($survey_id) {
        $stmt = $this->db->prepare("SELECT surveys.id as survey_id, surveys.title, surveys.description, users.id, users.name, users.surname, users.email, users.pass FROM surveys JOIN users ON surveys.creator = users.id WHERE surveys.id = ?");
        $stmt->execute(array($survey_id));
        $survey_row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($survey_row == NULL) {
            return NULL;
        }

        $creator = new User($survey_row["id"], $survey_row["name"], $survey_row["surname"],$survey_row["email"],$survey_row["pass"]);
        $survey = new Survey($survey_row["survey_id"], $survey_row["title"], $survey_row["description"], $creator);
        
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
        $stmt = $this->db->prepare("UPDATE surveys SET title=?, description=? WHERE id = ?");
        $stmt->execute(array($survey->getTitle(), $survey->getDescription(), $survey->getId()));
    }

    public function delete(Survey $survey) {
        $stmt = $this->db->prepare("DELETE FROM surveys WHERE id = ?");
        $stmt->execute(array($survey->getId()));
    }
}

?>