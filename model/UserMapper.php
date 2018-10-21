<?php


require_once(__DIR__."/../core/PDOConnection.php");


class UserMapper {

	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Fetch by Id.
	*/
	
	public function findById ($id){
		$stmt = $this->db->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute(array($id));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user == NULL) {
            return NULL;
        } else {
        return new User($user["id"], $user["name"], $user["surname"], $user["email"], $user["pass"]);
		}
	}
	
	/**
	* Fetch by email.
	*/
	
	public function findByEmail ($email){
		$stmt = $this->db->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute(array($email));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user == NULL) {
            return NULL;
        } else {
        return new User($user["id"], $user["name"], $user["surname"], $user["email"], $user["pass"]);
		}
	}
	/**
	* Saves, updates and deletes a User into the database
	*/
	public function save(User $user) {
		$stmt = $this->db->prepare("INSERT INTO users values (?,?,?,?)");
		$stmt->execute(array($user->getName(), $user->getSurname(),$user->getEmail(), $user->getPass()));
	}

	public function update(User $user) {
        $stmt = $this->db->prepare("UPDATE users SET name=?, surname=?, email = ?, pass = ? WHERE id = ?");
        $stmt->execute(array($user->getName(), $user->getSurname(), $user->getEmail(), $user->getPass(), $user->getId()));
    }
    public function delete(User $user) {
        $stmt = $this->db->prepare("DELETE FROM Users WHERE id = ?");
        $stmt->execute($user->getId());
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
