<?php

namespace Classes; 

require_once('Classes/LoginForm.php');

use Classes\LoginForm as LoginForm;

class Login extends LoginForm {

    private $username;
    private $password;

    public function __construct($username, $password) {
    $this->username = $username;
    $this->password = $password;
  
    }

    public function LoginUser(){

        $this->getUser($this->username, $this->password);
    }

}