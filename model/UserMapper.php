<?php


require_once(__DIR__."/../core/PDOConnection.php");


class UserMapper {

	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Saves a User into the database
	*/
	public function save($user) {
		$stmt = $this->db->prepare("INSERT INTO users values (?,?)");
		$stmt->execute(array($user->getUsername(), $user->getPasswd()));
	}

	/**
	* Checks if a given user is already in the database searching for the email
	*/
	public function userExists($email) {
		$stmt = $this->db->prepare("SELECT count(id) FROM users where email=?");
		$stmt->execute(array($email));
		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

}
