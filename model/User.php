<?php

require_once(__DIR__."/../core/ValidationException.php");


class User {

	
	private $username;
	private $usersurname;
	private $email;
	private $pass;
	
	/**
	* Constructor
	*/
	public function __construct($id=NULL, $username=NULL, $usersurname=NULL, $email=NULL, $pass=NULL) {
		$this->id = $id;
		$this->username = $username;
		$this->usersurname = $usersurname;
		$this->email = $email;
		$this->pass = $pass;
	}

	/**
	* Getter and setter of id.
	*/
	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	* Geter and seter of username.
	*/
	public function getUsername() {
		return $this->username;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	* Getter and setter of usersurname.
	*/
	public function getUsersurname() {
		return $this->usersurname;
	}

	public function setUsersurname($usersurname) {
		$this->usersurname = $usersurname;
	}

	/**
	* Getter and setter of email.	
	*/
	
	public function getEmail() {
		return $this->email;
	}
	
	public function setEmail($email){
		$this->email = $email;
	}
	
	/**
	* Getter and setter of pass.
	*/
	public function getPass() {
		return $this->pass;
	}
	
	public function setPassword($pass) {
		$this->pass = $pass;
	}

	/**
	* Validation for Register
	*/
	public function checkIsValidForRegister() {
		$errors = array();
		if (strlen($this->username) < 5) {
			$errors["username"] = "Username must be at least 5 characters length";
		}
		if (strlen($this->pass) < 5) {
			$errors["pass"] = "Password must be at least 5 characters length";
		}
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			$errors["email"] = "Esta dirección de correo no es válida.";
		}
		if (sizeof($errors)>0){
			throw new ValidationException($errors, "user is not valid");
		}
	}
}
