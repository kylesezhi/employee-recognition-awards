<?php
//Database information
require "dbconfig.php";

//Turn on error reporting
ini_set('display_errors', 'On');

//Access current session
session_start();

//create award
require "texCert.php";

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

    <title>Employee Recognition Awards - View Award</title>

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
            <h1 class="page-header">Award Sent Confirmation</h1>

            <?php

            $awardTitle = $_POST['awardTitle'];
            $customTitle = $_POST['customAwardTitle'];
			$proclamation = $_POST['proclamation'];
            $recipientFirstName = $_POST['recipientFirstNameInput'];
            $recipientLastName = $_POST['recipientLastNameInput'];
            $recipientEmail = $_POST['recipientEmailInput'];
            $awardDate = $_POST['awardDateInput'];
            $awardClassID = "";
            $awardID = "";		

            /* Get class ID for award title */
            //Prepare SELECT statement
            if(!($stmt = $mysqli->prepare("SELECT c.id FROM class c WHERE c.title = ?;"))){
                echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
            }

            //Bind parameters
            if ($awardTitle == "customTitle") {
                $stmt->bind_param("s", $customTitle);

            }
            else {
                $stmt->bind_param("s", $awardTitle);
            }

            //Execute the SELECT statement
            if(!$stmt->execute()){
                echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }

            //Bind results to variables
            if(!$stmt->bind_result($awardClassID)){
                echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }

            //If no result, no class ID for this award title yet, so insert new record for this title
            if(!$stmt->fetch()){

                //Prepare INSERT statement
                if(!($stmt2 = $mysqli->prepare("INSERT INTO class (title) VALUES (?)"))){
                    echo "Prepare failed: "  . $stmt2->errno . " " . $stmt2->error;
                }

                //Bind values to variables
                if ($awardTitle == "customTitle") {
                    if(!($stmt2->bind_param("s",$customTitle))){
                        echo "Bind failed: "  . $stmt2->errno . " " . $stmt2->error;
                    }
                }
                else {
                    if(!($stmt2->bind_param("s",$awardTitle))){
                        echo "Bind failed: "  . $stmt2->errno . " " . $stmt2->error;
                    }
                }

                //Execute the INSERT statement
                if(!$stmt2->execute()){
                    echo "Execute failed: "  . $stmt2->errno . " " . $stmt2->error;
                }
                //Save ID of new class
                else {
                    $awardClassID = $stmt2->insert_id;
                }

                $stmt2->close();
            }

            $stmt->close();

            //Insert new award record
            if(!($stmt = $mysqli->prepare("INSERT INTO award (user_id, class_id, first_name, last_name, email, award_date, proclamation) VALUES (?,?,?,?,?,?,?)"))){
                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }

            //Bind the values to variables
            if(!($stmt->bind_param("iisssss", $_SESSION["user_id"], $awardClassID, $recipientFirstName, $recipientLastName, $recipientEmail, $awardDate, $proclamation))){
                echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
            }

            //Execute the INSERT statement
            if(!$stmt->execute()){
                echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
            }
            //Save ID of new award
            else {
                $awardID = $stmt->insert_id;
            }

			//Call texCert to generate and email award
			texCert($awardID);
			
			//Inform user of success
			echo '<p>An Award for ';
			if ($awardTitle == "customTitle") {
                echo $customTitle;
            }
            else {
                echo $awardTitle;
            }
			echo ' has been sent to ' . $recipientFirstName . ' ' . $recipientLastName . ' at ' . $recipientEmail . '</p>';
			
			//Display button that can be clicked to view the award
			echo
				"<form action='viewAward.php' method='post' target='_blank'>
					<input type='hidden' name='id' value='" . $awardID . "'/>
					<div class='form-group'>
                        <button type='submit' class='btn btn-lg btn-primary '>View Award</button>
					</div>
				</form>";
 ?>


        </div>
    </div>
</div>
</body>
</html>