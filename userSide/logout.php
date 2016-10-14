<?php
//Access current session
session_start();

//Clear session variables
unset($_SESSION['username']);

//End existing session
session_destroy();

//Redirect to login page
header('Location: login.php');
?>