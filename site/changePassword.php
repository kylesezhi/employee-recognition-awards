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

//Boolean for whether status message should be displayed (off by default)
$status = 0;

//Connect to the database
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
if($mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

//Check variables received from form
if (isset($_POST['oldPass']) & isset($_POST['newPass']) & isset($_POST['conNewPass'])) {
	
	//Get old password from database and check against old password provided in form
	if(!($stmt = $mysqli->prepare("SELECT password FROM award_user WHERE id=?"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}

    //Bind parameters
    $stmt->bind_param("s", $_SESSION["user_id"]);

    //Execute the SELECT statement
    if(!$stmt->execute()){
        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }

    //Bind values to variables
    if(!$stmt->bind_result($existingPassword)){
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
	
	//Fetch the existing password
	$stmt->fetch();
	
	//Close statement
	$stmt->close();
	
	//If existing password doesn't match provided "old password", set status to 1
	if ($existingPassword != $_POST['oldPass']) {
		$status = 1;
	}
	
	//If new password and confirmation of new password don't match, set status to 2
	else if ($_POST['newPass'] != $_POST['conNewPass']) {
		$status = 2;
	}
	
	//If new password is the same as the old password, set status to 3
	else if ($existingPassword == $_POST['newPass']) {
		$status = 3;
	}
	
	//If everything checks out, change the password in database to new password and set status to 4
	else {
		if(!($stmt = $mysqli->prepare("UPDATE award_user SET password = ? WHERE id = ?;"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!($stmt->bind_param("si",$_POST['newPass'],$_SESSION['user_id']))){
			echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
		}
		
		else {
			$status = 4;
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employee Recognition Awards - Change Password</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="dashboard.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="awardform.css" rel="stylesheet">

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
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Change Password</h1>
			
			<form class="form-horizontal" action="changePassword.php" method="post">
			
				<div class="form-group">
					<label class="control-label col-sm-2" for="oldPass">Old Password:</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="oldPass" name="oldPass" placeholder="Old Password" required>
						</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="newPass">New Password:</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="newPass" name="newPass" placeholder="New Password" required>
						</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="conNewPass">Confirm New Password:</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="conNewPass" name="conNewPass" placeholder="Confirm New Password" required>
						</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-lg btn-primary ">Submit</button>
					</div>
				</div>
				
				<div class="form-group">
				<?php
				if ($status == 1) {
					echo "<div class='alert alert-danger' role='alert'><strong>Error! </strong>Old password incorrect. Password not changed. Please try again.</div>";
				}
				
				else if ($status == 2) {
					echo "<div class='alert alert-danger' role='alert'><strong>Error! </strong>New password does not match. Password not changed. Please try again.</div>";
				}
				
				else if ($status == 3) {
					echo "<div class='alert alert-danger' role='alert'><strong>Error! </strong>New password is the same as the old password. Password not changed. Please try again.</div>";
				}
				
				else if ($status == 4) {
					echo "<div class=\"alert alert-success\" role=\"alert\"><strong>Success!</strong> Password changed.</div>";
					echo '<a href="userAccount.php" class="btn btn-md btn-primary" role="button">Back</a>';
				}
				?>
				</div>
				
			</form>

        </div>
    </div>
</div>
</body>
</html>
