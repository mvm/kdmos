<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");
require_once(__DIR__."/../model/User.php");

class BaseController {

	protected $view;
	protected $currentUser;
	protected $currentUserId;

	public function __construct() {

		$this->view = ViewManager::getInstance();

		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if(isset($_SESSION["currentuser"])) {
			$this->currentUser = new User();
			$this->currentUser->setName($_SESSION["currentuser"]);
			$this->view->setVariable("currentusername", $this->currentUser->getName());
		}
		
		if(isset($_SESSION["currentuserid"])) {
            $this->currentUserId = $_SESSION["currentuserid"];
        }
	}
}
