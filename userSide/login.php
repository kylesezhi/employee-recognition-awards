<?php
//Access current session
session_start();

//If both username and password entered in login form, set session variables
if (isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {

    //Get values from form
    $username = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];

    //Save session variables
    $_SESSION['username'] = $username;

    //Redirect to main user page
    header('Location: generateAward.php');
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

        <form class="form-signin" action="login.php" method="post">
            <h2 class="form-signin-heading">Login:</h2>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>

        <a href="passwordRetrieve.php">I forgot my password</a>
        <br>
        <br>

        <br>
        <a href="adminHome.php">Temp Admin Login</a>


    </div>

</div>




</body>
</html>