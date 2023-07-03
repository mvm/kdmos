 <?php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Vote.php");
require_once(__DIR__."/../model/Survey.php");
require_once(__DIR__."/../model/User.php");

class VoteMapper{
	private $db;
	
	public function __construct() {
        $this->db = PDOConnection::getInstance();
    }
	
	public function findOptionsBySurveyId($survey_id){
		$stmt = $this->db->prepare("SELECT * FROM options WHERE survey_id = ? ORDER BY day, start");
        $stmt->execute(array($survey_id));
        $options_row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$options_by_survey = array();
		foreach($options_row as $option){
			array_push ($options_by_survey, new Option($option["id"], $survey_id, $option["day"], $option["start"], $option["end"]));
		}
		
        return $options_by_survey;       
	}	
		
	public function findBySurveyId($survey_id){
		$stmt = $this->db->prepare("SELECT votes.user_id, users.name, users.surname, votes.option_id, 
		options.day, options.start, options.end, votes.vote FROM votes JOIN options ON options.id=votes.option_id JOIN users ON users.id=votes.user_id 
		WHERE options.survey_id = ? ORDER BY votes.option_id, votes.user_id");
        $stmt->execute(array($survey_id));
        $votes_row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$votes_by_survey = array();
		
		foreach($votes_row as $vote) {
            array_push ($votes_by_survey, new Vote(new User($vote["user_id"], $vote["name"], $vote["surname"], NULL, NULL), 
										new Option($vote["option_id"], $survey_id, $vote["day"], $vote["start"], $vote["end"]),
											$vote["vote"]));
        }
		return $votes_by_survey;
	}


	public function save(Vote $vote) {
	$stmt = $this->db->prepare("INSERT INTO votes values (?,?,?)");
	$stmt->execute(array($vote->getUserId(), $vote->getOptionId(), $vote->getVote()));
	}

	public function update(Vote $vote) {
        $stmt = $this->db->prepare("UPDATE votes SET vote=? where user_id =? and option_id=? ");
        $stmt->execute(array($vote->getVote(), $vote->getUserId() , $vote->getOptionId()));
	}

	public function checkIfExists($user_id, $option_id){
		$stmt = $this->db->prepare("SELECT count(user_id) FROM votes WHERE user_id = ? AND option_id = ?");
        $stmt->execute(array($user_id, $option_id));
        if ($stmt->fetchColumn() > 0) {
            return true;
        }     
	}
	
}