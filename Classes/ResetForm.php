<?php
namespace Classes;

require_once('Classes/Dbh.php');

use Classes\Dbh as Dbh;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

date_default_timezone_set('America/Los_Angeles');

require 'vendor/autoload.php';

class ResetForm extends Dbh {

    public function sendEmail ($email) {
        
        $bytes = random_bytes(5);
        $password = bin2hex($bytes);
        // $this->email = $email;

        $mail = new PHPMailer();
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        //SMTP::DEBUG_OFF = off (for production use)
        //SMTP::DEBUG_CLIENT = client messages
        //SMTP::DEBUG_SERVER = client and server messages
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        //Set the hostname of the mail server
        $mail->Host = 'smtp-relay.sendinblue.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 587;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication
        $mail->Username = 'luciammperu@gmail.com';
        //Password to use for SMTP authentication
        $mail->Password = '5FaS7Yxg1H9ThKDy';
        //Set who the message is to be sent from
        $mail->setFrom('luciammperu@gmail.com', 'Lucia Martin');
        //Set an alternative reply-to address
        $mail->addReplyTo('luciammperu@gmail.com', 'First Last');
        //Set who the message is to be sent to
        $mail->addAddress($email);
        //Set the subject line
        $mail->Subject = 'Password Reset';
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $message = "<p>We received a password reset request for this email. </p><p>Your new password is: $password </p><p>Click the link below to activate this as your new password.</p><a href='http://localhost:3000/final-project/'>Activate my Password</a>";
        $mail->msgHTML($message);

        if (!$mail->send()) {
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
            return "something went wrong resetting your password";
        } else {
            $this->resetPassword($password, $email);
            return 'Message sent to ' . $email;
        }
        
    }

    public function resetPassword($password, $email) {

        $statement = $this->create_connection()->prepare('UPDATE Users SET password = ? WHERE username = ? ');
           
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement->execute([$hashPassword, $email]);

    }
}

?>