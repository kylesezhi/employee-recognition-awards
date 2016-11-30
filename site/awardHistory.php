<?php
require_once("dbconfig.php");

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
                <li><a href="generateAward.php">Generate Award </a></li>
                <li class="active"><a href="awardHistory.php">Award History<span class="sr-only">(current)</span></a></li>
                <li><a href="userAccount.php">Account Information</a></li>
            </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Award History</h1>

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

                if(!$stmt->fetch()) {
                    echo "<p>You haven't created any awards yet. Give it a try!</p>";
                    echo "<a href='generateAward.php' class='btn btn-md btn-primary' role='button'>Generate Award</a>";
                }

                //Build table showing awards previously created by this user
                else {
                    echo "<p>You've created and sent the following awards:</p>";
                    echo "<table class='table table-hover'>";
                    echo "<thead>";
                    echo "<th>Award Name</th>";
                    echo "<th>Award Recipient</th>";
                    echo "<th>Award Date</th>";
                    echo "</thead>";
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<td>" . $award_title . "</td>";
                    echo "<td>" . $recipient_first_name . " " . $recipient_last_name . "</td>";
                    echo "<td>" . $award_date . "</td>";
                    
					//Display button that can be clicked to view the award
					echo "<td>";
					echo
						"<form action='viewAward.php' method='post' target='_blank'>
								<input type='hidden' name='id' value='" . $award_id . "'/>
								<div class='form-group'>
									<button type='submit' class='btn btn-md btn-primary '>View Award</button>
								</div>
							</form>";
					echo "</td>";
							
					//Display button that can be clicked to delete the award
					echo "<td>";
					echo
						"<form action='deleteAward.php' method='post'>
								<input type='hidden' name='id' value='" . $award_id . "'/>
								<div class='form-group'>
									<button type='submit' class='btn btn-md btn-primary'>Delete Award</button>
								</div>
							</form>";
					echo "</td>";
					
                    echo "</tr>";

                    //Fill remaining rows if any
                    while($stmt->fetch()){
                        echo "<tr>";
                        echo "<td>" . $award_title . "</td>";
                        echo "<td>" . $recipient_first_name . " " . $recipient_last_name . "</td>";
                        echo "<td>" . $award_date . "</td>";
                        
						//Display button that can be clicked to view the award
						echo "<td>";
						echo
							"<form action='viewAward.php' method='post' target='_blank'>
								<input type='hidden' name='id' value='" . $award_id . "'/>
								<div class='form-group'>
									<button type='submit' class='btn btn-md btn-primary '>View Award</button>
								</div>
							</form>";
						echo "</td>";
                        
						//Display button that can be clicked to delete the award
						echo "<td>";
						echo
							"<form action='deleteAward.php' method='post'>
									<input type='hidden' name='id' value='" . $award_id . "'/>
									<div class='form-group'>
										<button type='submit' class='btn btn-md btn-primary '>Delete Award</button>
									</div>
								</form>";
						echo "</td>";
						
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                }

                //Close mySQL statement
                $stmt->close();

                ?>

        </div>
    </div>
</div>


</body>
</html>
