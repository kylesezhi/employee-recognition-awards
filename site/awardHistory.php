<?php
//Turn on error reporting
ini_set('display_errors', 'On');

//Access current session
session_start();

//Database information
require "dbconfig.php";

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

    <title>Employee Recognition Awards - Award History</title>

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
            <a class="navbar-brand" href="generateAward.php">Employee Recognition Awards</a>
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
                <li><a href="generateAward.php">Generate Award </a></li>
                <li class="active"><a href="awardHistory.php">Award History<span class="sr-only">(current)</span></a></li>
                <li><a href="userAccount.php">Account Information</a></li>
            </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Award History</h1>

            <p>You've created and sent the following awards:</p>

            <table class="table table-hover">
                <thead>
                <th>Award Name</th>
                <th>Award Recipient</th>
                <th>Award Date</th>

                </thead>
                <tbody>

                <?php
                //Prepare SELECT statement to get award history data
                if(!($stmt = $mysqli->prepare("SELECT a.first_name, a.last_name, a.award_date, a.id, c.title FROM award a INNER JOIN class c ON a.class_id = c.id INNER JOIN award_user au ON a.user_id = au.id WHERE au.id = ?;"))){
                    echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                }

                //Bind parameters
                $stmt->bind_param("s", $_SESSION["user_id"]);

                //Execute the SELECT statement
                if(!$stmt->execute()){
                    echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }

                //Bind results to variables
                if(!$stmt->bind_result($recipient_first_name, $recipient_last_name, $award_date, $award_id, $award_title)){
                    echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }

                //Go through each row of returned results and build table
                while($stmt->fetch()){

                    echo "<tr>";
                    echo "<td>" . $award_title . "</td>";
                    echo "<td>" . $recipient_first_name . " " . $recipient_last_name . "</td>";
                    echo "<td>" . $award_date . "</td>";
                    echo "<td><a href='#' class='btn btn-info' role='button'>View Award</a></td>";
                    echo "</tr>";
                }

                //Close mySQL statement
                $stmt->close();

                ?>
                </tbody>
            </table>












        </div>
    </div>
</div>


</body>
</html>