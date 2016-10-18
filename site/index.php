<?php

//Turn on error reporting
ini_set('display_errors', 'On');

//Access current session
session_start();

//Enforce the correct user type
if($_SESSION['account_type'] === "regular") {
	header('Location: generateAward.php');
	exit();
} else if($_SESSION['account_type'] === "admin") {
	header('Location: users.php');
	exit();
}

//Database information
require "dbconfig.php";

//Connect to the database
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
if($mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

//If both username and password entered in login form, set session variables
if (isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {

    //Get values from form
    $username = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];

    //Prepare SELECT statement to check if username and password match found in database
    if(!($stmt = $mysqli->prepare("SELECT AU.id, ACT.title FROM award_user AU INNER JOIN act_type ACT ON ACT.id = AU.act_id WHERE AU.email=? AND AU.password=?"))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    $stmt->bind_param("ss", $username, $password);

    //Execute the SELECT statement
    if(!$stmt->execute()){
        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }

    //Bind values to variables
    if(!$stmt->bind_result($user_id, $account_type)){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }

    if(!$stmt->fetch()){
        echo "USER NOT IN DATABASE";
    }

    else {
        //Save session variables
        $_SESSION['username'] = $username;
        $_SESSION['account_type'] = $account_type;

        $stmt->close();

        //Redirect to main user page
        if($account_type == "admin") {
          header('Location: users.php');
          exit();
        } else {
          header('Location: generateAward.php');
          exit();
        }
    }

    $stmt->close();

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Recognition Awards</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="cover.css" rel="stylesheet">
</head>
<body>

<div class="site-wrapper">

    <div class="container">

        <div class="jumbotron">
            <h1>Employee Recognition Awards</h1>
            <p class="lead">Recognize the efforts and achievements of your employees!</p>
        </div>

        <form class="form-signin" action="index.php" method="post">
            <h2 class="form-signin-heading">Login:</h2>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>

        <a href="passwordRetrieve.php">I forgot my password</a>

    </div>

</div>




</body>
</html>
