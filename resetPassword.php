<?php

require_once('Classes/ResetForm.php');

use Classes\ResetForm as ResetForm;

if(isset($_POST['resetPassword'])) {

    $resetForm = new ResetForm;
    $sentEmail = $resetForm->sendEmail($_POST['email']);

    echo $sentEmail;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/app.css">
    <title>Document</title>

</head>
<body>
    <a href="./home.php">
    <button>
        Log in
    </button>
    </a>
    
</body>
</html>