 <?php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Vote.php");
require_once(__DIR__."/../model/Option.php");
require_once(__DIR__."/../model/User.php");

class VoteMapper{
	private $db;
	
	public function __construct() {
        $this->db = PDOConnection::getInstance();
    }
	
	public function findByOptionId($option_id){
		$stmt = $this->db->prepare("SELECT user_id , vote FROM votes WHERE option.id = ?");
        $stmt->execute(array($option_id));
        $options_row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($options_row == NULL) {
            return NULL;
        }
	}
	
	
	public function findBySurveyId($survey_id){
		$stmt = $this->db->prepare("SELECT votes.user_id, votes.option_id, votes.vote, 
		options.day, options.start, options.end FROM votes JOIN options ON options.id=votes.option_id WHERE options.survey_id = '?'");
        $stmt->execute(array($survey_id));
        $survey_row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($survey_row == NULL) {
            return NULL;
        }
	}


	public function save(Vote $vote) {
	$stmt = $this->db->prepare("INSERT INTO votes values (?,?,?)");
	$stmt->execute(array($vote->getUserId(), $vote->getOptionId(), $vote->getVote()));
	}

	public function update(Vote $vote) {
        $stmt = $this->db->prepare("UPDATE votes SET vote=? where user_id =? and option_id=? ");
        $stmt->execute(array($vote->getVote(), $vote->getUserId() , $vote->getOptionId()));
    }
