<?php
//Turn on error reporting
ini_set('display_errors', 'On');

//Access current session
session_start();

//Clear session variables
unset($_SESSION['username']);
unset($_SESSION['user_id']);
unset($_SESSION['account_type']);

//End existing session
session_destroy();

//Redirect to login page
header('Location: index.php');
?>