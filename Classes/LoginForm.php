<?php
namespace Classes;

require_once('Classes/Dbh.php');
require_once('Classes/ResetForm.php');

use Classes\Dbh as Dbh;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Classes\ResetForm;

date_default_timezone_set('America/Los_Angeles');

require 'vendor/autoload.php';

class LoginForm extends Dbh{

    public function getUser($username, $password) {
        $connection = $this->create_connection();
        $statement = $connection->prepare("SELECT status FROM Users WHERE username = ? ");
        $statement->execute([$username]);
        $status = $statement->fetchAll();
        // echo $status[0]['status'];
        if($status == null) {
            echo "<br>this username doesn't exist!";
            exit();
        }
        if($status[0]['status'] !== "active") {
            echo "<br>You need to activate your account first";
            exit();
        }

        $statement = $connection->prepare("SELECT password FROM Users WHERE username = ? ");
           
        $statement->execute([$username]);

        $hashedPassword = $statement->fetchAll();
        $checkPassword = password_verify($password, $hashedPassword[0]['password']);
    
        //the passwords are the same
        if($checkPassword == true){
            // session_start();
            $statement = $connection->prepare("SELECT * FROM Users WHERE username = ? AND password = ?");

            $statement->execute([$username, $hashedPassword[0]['password']]);

            if($statement->rowCount() !== 0) {
                $user = $statement->fetchAll();
                $_SESSION['username'] = $user[0]['username'];                
                $_SESSION['id'] = $user[0]['id']; 
                $_SESSION ['loginTime'] = time();
            }
          
            //then you fetch all the users info
            header("Location: dashboard.php");
        
        } else {
            $statement = $connection->prepare("UPDATE Users SET attempts = attempts - 1 WHERE username = ? ");
            $statement->execute([$username]);

            //check if attempts is now 0, then lock account, and set attempts back to 3

            $statement = $connection->prepare("SELECT attempts, token from Users where username = ? ");
            $statement->execute([$username]);

            $result = $statement->fetchAll();

            //check why some users went down to -3 attempts :stand
            if($result[0]['attempts'] <= 0) {
                $statement = $connection->prepare("UPDATE Users SET status = 'locked' WHERE username = ?");
                $statement->execute([$username]);
                echo "Too many incorrect Attempts. Your account has been locked! Please check your email for next steps";
                $this->sendLockedEmail($username, $result[0]['token']);
                
            } else {
                echo "incorrect login information!";
            }


        }
    }

    public function activateUser($token){
        $statement = $this->create_connection()->prepare("UPDATE Users SET status = 'active', attempts = 3 WHERE token = ? ");
        $statement->execute([$token]);
       
        // $status = $statement->fetchAll();
    }

    protected function sendLockedEmail ($email, $token) {
            $bytes = random_bytes(5);
            $password = bin2hex($bytes);
            $updatePassword = new ResetForm;
            $updatePassword->resetPassword( $password, $email);

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
            $mail->Subject = 'New Password for Locked Account';
            $message = "<p>Your account has been locked due to too many attempts. </p><p>To reactivate your account, click the link below and sign in with your new password: $password </p><a href='http://localhost:3000/final-project/index.php?token=$token'>Re-activate my Account</a>";
            $mail->msgHTML($message);
    
            $mail->send();
    }


}

?>