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
	
	public function findByOptionId($option_id){
		$stmt = $this->db->prepare("SELECT user_id , vote FROM vote WHERE option.id = ?");
        $stmt->execute(array($option_id));
        $options_row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($options_row == NULL) {
            return NULL;
        }
	}
	/*
	public function findBySurveyId($survey_id){
		$stmt = $this->db->prepare("SELECT surveys.id, surveys.title, surveys.description, 
		users.id, users.name FROM surveys JOIN users WHERE surveys.id = ?");
        $stmt->execute(array($survey_id));
        $survey_row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($survey_row == NULL) {
            return NULL;
        }
	}
*/

	public function save(Vote $vote) {
	$stmt = $this->db->prepare("INSERT INTO vote values (?,?,?)");
	$stmt->execute(array($vote->getUserId(), $vote->getOptionId(), $vote->getVote()));
	}

	public function update(Vote $vote) {
        $stmt = $this->db->prepare("UPDATE vote SET vote=? where user_id =? and option_id=? ");
        $stmt->execute(array($vote->getVote(), $vote->getUserId() , $vote->getOptionId()));
    }