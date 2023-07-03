<?php

require_once(__DIR__."/../core/ValidationException.php");


class User {

	private $id;
	private $name;
	private $surname;
	private $email;
	private $pass;
	
	/**
	* Constructor
	*/
	public function __construct($id=NULL, $name=NULL, $surname=NULL, $email=NULL, $pass=NULL) {
		$this->id = $id;
		$this->name = $name;
		$this->surname = $surname;
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
	* Geter and seter of name.
	*/
	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	/**
	* Getter and setter of surname.
	*/
	public function getSurname() {
		return $this->surname;
	}

	public function setSurname($surname) {
		$this->surname = $surname;
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
	
	public function setPass($pass) {
		$this->pass = $pass;
	}

	/**
	* Validation for Register
	*/
	public function checkIsValidForRegister() {
		$errors = array();
		if (strlen($this->name) < 5) {
			$errors["name"] = "Name must be at least 5 characters length";
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
