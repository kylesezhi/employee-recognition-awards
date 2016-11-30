<?php
	include "dbconfig.php";
	include "createToken.php";
	ini_set('display_errors', 'On');
	
	//connect to database - host, username, pass, db
	$db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
    	if ($db ->connect_error){
			die (" ERROR Could not connect to database. Please try again later. ". $db->conenct_error());
		}
		
	//check if id and token are set
	if (empty($_GET['id']) && empty($_GET['token'])){
		header('Location: index.php');
		exit();
	}
	
	//check that id and token are valid
	if (isset($_GET['id'])&& isset($_GET['token'])){
		$id = $_GET['id'];
		$token = $_GET['token'];
		
		$query = "SELECT * FROM award_user WHERE id = ? AND resetToken = ?;";
		$stmt = $db->prepare($query);
		$stmt -> bind_param("is", $id, $token);
		$stmt -> execute();
		$stmt ->store_result();
		$rows = $stmt->num_rows;
		$stmt->free_result();
		$stmt -> close();
		
		if ($rows === 1){
			//confirm valid id and token
			if (isset($_POST['newPass'])&& isset($_POST['conPass'])){
				$pass = $_POST['newPass'];
				$confirm = $_POST['conPass'];
				
					
				//confirm both passwords match
				if ($pass === $confirm){
					//add to database
					$tNew = createToken(8);
					
					$query2 = "UPDATE award_user SET password = ?, resetToken = ? WHERE id = ?;";
					$stmt2 = $db->prepare($query2);
					$stmt2->bind_param("ssi", $pass, $tNew, $id);
					$stmt2->execute();
					$stmt2->close();
					
					header('Location:recovered.php');
					exit();
				}//end add to database
				
				else {
					$msg = "<div class ='alert alert-warning'> <a href='#' class='close' date-dismiss='alert'>&times;</a>
							<strong>ERROR!</strong> Passwords do not match. </div>";
				}
			}//end password reset
					
		}//end valid url
		
		else{
			header('Location: invalidURL.php');
		}//end invalid url
	}//end isset
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Recognition Awards - Password Recovery</title>
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

    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="index.php">Return to Login Page <span class="sr-only">(current)</span></a></li>
            </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Password Recovery</h1>
			
	       	<form class="form-horizontal" action="" method="post">
			<?php
				if (isset($msg)){
					echo $msg;
				}
			?>	
				<div class="form-group">
                    <label class="control-label col-sm-2" for="pass">New Password:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="pass" name="newPass" placeholder="New Password" required>
                        </div>
                </div>
				 <div class="form-group">
                    <label class="control-label col-sm-2" for="confirm">Confirm Password:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="confirm" name="conPass" placeholder="Confim Password" required>
                        </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-lg btn-primary ">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>