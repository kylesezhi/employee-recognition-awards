<?php
	include "dbconfig.php";
	include "createToken.php";
	require "./mailer/PHPMailerAutoload.php";
 	ini_set('display_errors', 'On');
	
		//connect to database - host, username, pass, db
	$db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
    	if ($db ->connect_error){
			die (" ERROR Could not connect to database. Please try again later. ". $db->conenct_error());
		}
		
	//check if form has been filled out
	if (isset($_POST['emailInput']) && $_POST['emailInput'] !== ""){
		//check if valid email
		$email = $_POST['emailInput'];
			
		if (!filter_var($email,FILTER_VALIDATE_EMAIL)){	
			$msg = "<div class ='alert alert-warning'> <a href='#' class='close' date-dismiss='alert'>&times;</a>
					<strong>ERROR!</strong> The email is invalid. </div>";
		}//end if not valid
		
		//else valid email
		else{
			$id = 0;
			//check if email is in database
			$query = "SELECT id FROM award_user WHERE email = ?";
			$stmt = $db->prepare($query);
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$stmt-> bind_result($id);
			$stmt-> fetch();
			$stmt->close();
					
			//if user does exist create token and send email
			if ($id > 0){
				//get token
				$token = createToken(8);
				
				//add to database
				$query2 = "UPDATE award_user SET resetToken= ? WHERE id = ?;";
				$stmt2 = $db->prepare($query2);
				$stmt2->bind_param("si", $token, $id);
				$stmt2->execute();
				$stmt2->close();
				
				//send email to user
				$mail = new PHPMailer(); 
	 
				//sender info setfrom must be from domain to avoid spam filter. set reply to valid email
				$mail -> setFrom("cskTech@web.engr.oregonstate.edu", 'CSKAdmin');
				$mail -> AddReplyTo ("pikec@oregonstate.edu");
		
				//receipent info
				$mail -> addAddress($email);
	
				//subject line
				$mail -> Subject = "Password Recovery Link";
	
				//create url and message
				$url= "http://web.engr.oregonstate.edu/~pikec/bolero/passReset.php?id=". $id . "&token=" . $token;
			    $msg = "Click this link to recover your password " . $url;
				
				//set body of email as the html message
				$mail -> isHTML (true);
				$mail -> MsgHTML ($msg);
				$mail -> AltBody = "Paste this link to recover your password" . $url;
				if(!$mail->Send()) {
					$err = 'Problem Sending Password Recovery Email';
				} 
				else {
					header('Location: resetSent.php');
					exit();
				}
			}//end valid email
			else{
				$msg = "<div class ='alert alert-warning'> <a href='#' class='close' date-dismiss='alert'>&times;</a>
							<strong>ERROR!</strong> The email does not exist. </div>";
			}
			
		}//end else
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
			
	        <p> Please enter your email address. You will receive a link via email to recover your password.</p>

       		<form class="form-horizontal" action="passwordRetrieve.php" method="post">
			<?php
				if (isset($msg)){
					echo $msg;
				}
			?>	
                <div class="form-group">
                    <label class="control-label col-sm-2" for="emailInput">Email Address:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="emailInput" name="emailInput" placeholder="Email Address">
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
