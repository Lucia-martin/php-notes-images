<?php
namespace Classes;

require_once('Classes/Dbh.php');

use Classes\Dbh as Dbh;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

date_default_timezone_set('America/Los_Angeles');

require 'vendor/autoload.php';

class SignupForm extends Dbh{

    public function setUser($username, $password) {

        $userExists = $this->checkUserExists($username);

        if($userExists){
            echo "This account already exists. Log in instead";

        } else {
            $statement = $this->create_connection()->prepare("INSERT INTO Users (username, password, token) values (?,?,?);");
        
            $token = bin2hex(openssl_random_pseudo_bytes(32));
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $statement->execute([$username, $hashPassword, $token]);
    
            echo "User " . $username . " has been set! Check your email to activate your account.  ";

            $this->sendActivationEmail($username, $token);

        }
        
    }

    protected function checkUserExists($username) {
        $statement = $this->create_connection()->prepare("SELECT * FROM Users WHERE username = ?");

        $statement->execute([$username]);

        if($statement->rowCount() == 0) {
            //ie user currently not in database
           return false;
        } else {
            return true;
        }
    }

    protected function sendActivationEmail ($email, $token) {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.sendinblue.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'luciammperu@gmail.com';
        $mail->Password = '5FaS7Yxg1H9ThKDy';
        $mail->setFrom('luciammperu@gmail.com', 'Lucia Martin');
        $mail->addReplyTo('luciammperu@gmail.com', 'Lucia Martin');
        $mail->addAddress($email);
        $mail->Subject = 'Activate Your Account';
        $message = "<p>Welcome to this php Note/Mood board!</p><p>Click the link below to activate your account so you can log in.</p><a href='http://localhost:3000/final-project/index.php?token=$token'>Activate my Account</a>";
        $mail->msgHTML($message);

        $mail->send();
    }
}

?>