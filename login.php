
<?php
    require_once('Classes/Login.php');

    use Classes\Login as Login;

    if(isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // signup class takes data and compares it to database data

        $login = new Login($username, $password);
        $login->LoginUser();
        // $signup->signupUser($username, $password);
    }

?>