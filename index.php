<?php
  require_once('Classes/LoginForm.php');
  use Classes\LoginForm as LoginForm;

if(isset($_GET['token'])){
    $token = $_GET['token'];

    $loginForm = new LoginForm;
    $loginForm->activateUser($token);

    echo "<section>You have activated your account! Thank you. You can now <a href='home.php' >sign in!</a></section>";

} else {
    header("Location: home.php");
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
  
</body>
</html>