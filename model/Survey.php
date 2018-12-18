<?php

require_once(__DIR__."/../core/ValidationException.php");

class Survey {
    private $id;
    private $title;
    private $description;
    private $creator;
    private $options;
    
    public function __construct($id=NULL, $title=NULL, $description=NULL, User $creator=NULL, array $options = NULL ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->creator = $creator;
        $this->options = $options;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function newId() {
        $this->id = rand();
        return $this->id;
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getCreator() {
        return $this->creator;
    }

    public function setCreator(User $creator) {
        $this->creator = $creator;
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOptions(array $options) {
        $this->options = $options;
    }

    public function checkIsValidForUpdate() {
        $errors = array();

        if(strlen(trim($this->title)) == 0) {
            $errors["title"] = "Title not specified";
        }
        
        if(sizeof($errors) > 0) {
            throw new ValidationException($errors, "survey not valid");
        }
    }
    
    public function checkIsValidForCreate() {
        $errors = array();

        if(strlen(trim($this->title)) == 0) {
            $errors["title"] = "must have title";
        }
        
        if($this->creator == NULL) {
            $errors["creator"] = "must have creator";
        }

        if($this->options == NULL) {
            $errors["options"] = "must have options";
        }

        foreach($this->options as $option) {
            $option->checkValid();
        }

        if(sizeof($errors) > 0) {
            throw new ValidationException($errors, "survey not valid");
        }
    }
}

?>