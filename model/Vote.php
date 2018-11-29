<?php

require_once(__DIR__."/../core/ValidationException.php");


class Vote{
	private $user_id;
	private $option_id;
	private $vote;
	
	public function __construct($user_id=NULL, $option_id=NULL, $vote=Null){
		$this->user_id = $user_id;
        $this->option_id = $option_id;
        $this->vote = $vote;
	}
	
	public function getUserId(){
		return $this->user_id;
	}
	
	public function setUserId($user_id){
		$this->user_id=$user_id;
	}
	
	public function getOptionId(){
		return $this->option_id;
	}
	
	public function setOptionID($option_id) {
		$this->option_id=$option_id;
	}
	
	public function getVote(){
		return $this->vote;
	}
	
	public function setVote($vote){
		$this->vote=$vote;
	}
}
