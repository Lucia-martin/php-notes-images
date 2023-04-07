<?php
session_start(); 
   require_once('Classes/Signup.php');
   require_once('Classes/Login.php');

   use Classes\Signup as Signup;
   use Classes\Login as Login;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./public/app.css">
</head>
<body>

<section>
    <div class="signUp">
        
<form action="./home.php" method="POST">
    <h3>SIGN-UP WITH EMAIL</h3>
    <label for="username">Username: </label>
    <input id="username" name="username" type="email" placeholder="example@gmail.com">
    <label for="password">Password: </label>
    <input id="password" name="password" type="password" placeholder="">
    <button type="submit" name="submitSignup"> Sign up </button>
    <br>

    <?php
 
    if(isset($_POST["submitSignup"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $signup = new Signup($username, $password);
        $signup->signupUser($username, $password);
    }

?>
</form>

</div>

<div class="signUp">
<form action="./home.php" method="POST">
    <h3>LOG IN WITH EMAIL</h3>
    <label for="username">Username: </label>
    <input id="username" name="username" type="email" placeholder="example@gmail.com">
    <label for="password">Password: </label>
    <input id="password" name="password" type="password" placeholder="">
    <button type="submit" name="submitLogin"> Log In </button>
    <br>

    <?php
  

    if(isset($_POST["submitLogin"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $login = new Login($username, $password);
        $login->LoginUser();
    }

?>
</form>

<a href="forgotPassword.php">forgot your password?</a>

</section>
</body>
</html>

