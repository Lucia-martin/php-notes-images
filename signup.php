
<?php
    // require_once('Classes/Dbh.php');
    require_once('Classes/Signup.php');

    // use Classes\Dbh as Dbh;
    use Classes\Signup as Signup;

    if(isset($_POST["submit"])) {
        //user's inputted data
        $username = $_POST["username"];
        $password = $_POST["password"];

        // signup class takes data and compares it to database data

        $signup = new Signup($username, $password);
        $signup->signupUser($username, $password);
    }

?>