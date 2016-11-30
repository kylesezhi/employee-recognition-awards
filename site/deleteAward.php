<?php
//Database information
require_once "dbconfig.php";

//Turn on error reporting
ini_set('display_errors', 'On');

//Access current session
session_start();

//Redirect if user not logged in, or if logged in as other type of user
if(!isset($_SESSION['account_type'])) {
    header('Location: index.php');
    exit();
}
else if($_SESSION['account_type'] === "admin") {
    header('Location: users.php');
    exit();
}

//Connect to the database
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
if($mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employee Recognition Awards - Delete Award</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="dashboard.css" rel="stylesheet">

</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-left" href="generateAward.php"><img src="img/logo_mini.png" height="50px"></a>
            <a class="navbar-brand" href="generateAward.php">&nbsp Employee Recognition Awards</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="userAccount.php">User: <?php echo $_SESSION["username"] ?></a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="generateAward.php">Generate Award</a></li>
                <li><a href="awardHistory.php">Award History</a></li>
                <li><a href="userAccount.php">Account Information</a></li>
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Award Delete Confirmation</h1>

            <?php

            $awardID = $_POST['id'];

            /* Get award info for confirmation message */
			
            //Prepare SELECT statement
            if(!($stmt = $mysqli->prepare("SELECT a.first_name, a.last_name, a.award_date, c.title FROM award a INNER JOIN class c ON a.class_id = c.id WHERE a.id = ?;"))){
                    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
            }
			
			//Bind parameters
            $stmt->bind_param("i", $awardID);

            //Execute the SELECT statement
            if(!$stmt->execute()){
                echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }

            //Bind results to variables
			if(!$stmt->bind_result($recipient_first_name, $recipient_last_name, $award_date, $award_title)){
				echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
			}
			
			$stmt->fetch();

            $stmt->close();
			
			/* Delete the award */

            //Prepare delete statement
            if(!($stmt = $mysqli->prepare("DELETE FROM award WHERE award.id = ?;"))){
                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }

            //Bind the values to variables
            if(!($stmt->bind_param("i", $awardID))){
                echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
            }

            //Execute the DELETE statement
            if(!$stmt->execute()){
                echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
            }
			else {
				//Inform user of successful delete
				echo '<p>The Award for ' . $award_title . ' given to ' . $recipient_first_name . ' ';
				echo $recipient_last_name . ' on ' . $award_date . ' has been successfully deleted.</p>';
				
				//Display button that can be clicked to return to award history
				echo "<a href='awardHistory.php' class='btn btn-md btn-primary' role='button'>Return to Award History</td>";
			}

			$stmt->close();

 ?>


        </div>
    </div>
</div>
</body>
</html>