<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../controller/BaseController.php");

/**
* Class UsersController
*/
class UsersController extends BaseController {

	
	private $userMapper;

	public function __construct() {
		parent::__construct();
		$this->userMapper = new UserMapper();
		$this->view->setLayout("default");
	}

	/**
	* Action to login
	*/
	public function login() {
		if (isset($_POST["email"])){
			if ($this->userMapper->isValidUser($_POST["email"], $_POST["pass"])) {
				$user = $this->userMapper->findByEmail($_POST["email"]);
				$_SESSION["currentuser"] = $user->getName();
				$_SESSION["currentuserid"] = $user->getId();
				$this->view->redirect("users", "login");
			}else{
				$errors = array();
				$errors["general"] = i18n("User is not valid");
				$this->view->setVariable("errors", $errors);
			}
		}

		$this->view->render("users", "login");
	}

	/**
	* Action to register
	*/
	public function register() {

		$user = new User();

		if (isset($_POST["email"])){ 
			$user->setName($_POST["name"]);
			$user->setSurname($_POST["surname"]);
			$user->setEmail($_POST["email"]);
			$user->setPass($_POST["pass"]);

			try{
				$user->checkIsValidForRegister(); 
				if (!$this->userMapper->userExists($_POST["email"])){
					$this->userMapper->save($user);
					$this->view->setFlash(i18n("User ").$user->getName().i18n(" successfully added. Please login now"));
					$this->view->redirect("users", "login");
				} else {
					$errors = array();
					$errors["email"] = i18n("User with this email already exists");
					$this->view->setVariable("errors", $errors);
				}
			}catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
			}
		}

		$this->view->setVariable("user", $user);
		$this->view->render("users", "register");

	}

	/**
	* Action to logout
	*/
	
	public function logout() {
		session_destroy();
		$this->view->redirect("users", "login");

	}

}
