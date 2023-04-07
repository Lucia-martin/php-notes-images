<?php

namespace Classes; 

require_once('Classes/SignupForm.php');

use Classes\SignupForm as SignupForm;

class Signup extends SignupForm {

    private $username;
    private $password;

    public function __construct($username, $password) {
    $this->username = $username;
    $this->password = $password;
  
    }

    public function signupUser(){
        if($this->checkEmail() == false){
            //email is not valid
            echo "This is not a valid email";
            exit();
        }

        $this->setUser($this->username, $this->password);
    }

    protected function checkEmail(){
        $validEmail;
        if (filter_var($this->username, FILTER_VALIDATE_EMAIL)) {
            $validEmail = true;
          } else {
            $validEmail = false;
        }

        return $validEmail;

    }
}