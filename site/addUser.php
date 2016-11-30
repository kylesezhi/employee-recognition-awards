<?php
require_once("dbconfig.php");
require "createToken.php";
require "./mailer/PHPMailerAutoload.php";
require_once('php_image_magician.php'); //http://phpimagemagician.jarrodoberto.com/

//Turn on error reporting
ini_set('display_errors', 'On');

//Access current session
session_start();

//Enforce the correct user type
if($_SESSION['account_type'] === "regular") {
	header('Location: generateAward.php');
	exit();
} else if($_SESSION['account_type'] !== "admin") {
	header('Location: index.php');
	exit();
}

//If the required fields are filled out, add to DB and return to User admin
if (isset($_POST['type']) && isset($_POST['first_name']) & isset($_POST['last_name']) & isset($_POST['email']) & isset($_POST['state'])) {
        
    //Connects to the database
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
    if($mysqli->connect_errno){
      echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
	
	$password = createToken(10);
    
    //Set usertype correctly: regular is 1 and admin is 2
    if($_POST['type'] === "regular") {
      if(!($stmt = $mysqli->prepare("INSERT INTO award_user (first_name, last_name, email, act_id, password, state) VALUES (?, ?, ?, 1, ?, ?);"))){
      	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
      }
      
      if(!($stmt->bind_param("sssss",$_POST['first_name'],$_POST['last_name'],$_POST['email'], $password, $_POST['state']))){
      	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
      }
    }
    if($_POST['type'] === "admin") {
      if(!($stmt = $mysqli->prepare("INSERT INTO award_user (first_name, last_name, email, act_id, password, state) VALUES (?, ?, ?, 2, ?, ?);"))){
      	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
      }
      
      if(!($stmt->bind_param("sssss",$_POST['first_name'],$_POST['last_name'],$_POST['email'], $password, $_POST['state']))){
      	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
      }
    } // end insert
    
    if(!$stmt->execute()){
    	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    }
	else {
		
		//Save ID of new user
		$newUserID = $stmt->insert_id;
		
		$stmt->close();
	
		//If signature file uploaded (optional), process and add to new account in database
		if (is_uploaded_file($_FILES['signature']['tmp_name'])) {
			
			//Temp file name
			$tempFilename = 'tempSig.png';
			
			//read binary data from image file
			$imgString = file_get_contents($_FILES['signature']['tmp_name']);
			
			//create image from string
			$image = imagecreatefromstring($imgString);
				
			//Correct for .png transparency - adapted from http://stackoverflow.com/questions/11364160/png-black-background-when-upload-and-resize-image
			imagecolortransparent($image, imagecolorallocatealpha($image, 0, 0, 0, 127));
			imagealphablending($image, false);
			imagesavealpha($image, true);
			
			//Save temp image
			imagepng($image, $tempFilename, 0);
			
			//Resize temp image using PHP Image Magician: http://phpimagemagician.jarrodoberto.com/
			$sigFile = new imageLib($tempFilename);
			$sigFile->resizeImage(250, 75, 'portrait');
			$sigFile->saveImage($tempFilename, 100);
				
			//Get the resized temp image's binary data
			$signature = fopen($tempFilename, 'rb');			
								
			//Update the signature in database using function
			$dbinfo = "mysql:host=" . DB_HOST . ";dbname=" . DB_DB;
			$dbh = new PDO($dbinfo, DB_USER, DB_PASSWORD);
			
			//Set Error Mode
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			 
			//Prepare Update statement
			$stmt = $dbh->prepare("UPDATE award_user SET sig = ? WHERE id = ?");
			 
			//Bind parameters
			$stmt->bindParam(1, $signature, PDO::PARAM_LOB);
			$stmt->bindParam(2, $newUserID);
			
			if(!$stmt->execute()){
				echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
			}
			
			//Delete the temp file
			unlink($tempFilename);	
		}
	
		//send email to new user/admin
		$mail = new PHPMailer(); 
		
		//sender info setfrom must be from domain to avoid spam filter. set reply to valid email
		$mail -> setFrom("cskTech@web.engr.oregonstate.edu", 'CSKAdmin');
		$mail -> AddReplyTo ("pikec@oregonstate.edu");
		
		//receipent info
		$mail -> addAddress($_POST['email']);
		
		//subject line
		$mail -> Subject = "Employee Recognition New Account";
		
		//read html message
		$msg = file_get_contents("./template/email_account.html");
		
		//replace placeholders with data
		$fullName = $_POST['first_name'] . " ". $_POST['last_name'];
		$msg = str_replace ("%fullName%", $fullName, $msg);
		$msg = str_replace ("%temp%", $password, $msg);
		
		//set body of email as the html message
		$mail -> isHTML (true);
		$mail -> MsgHTML ($msg);
		$mail -> AltBody = "Your employee recognition account has been created. Your temporary password is ". $password;
		
		//send and check for error
		if(!$mail -> Send()){
			$msg =  "Error sending mail.";
		}
		else{
			header('Location: users.php');
			exit();
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Employee Recognition Awards - Add User</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
		
    <!-- Custom styles for forms -->
    <link href="css/forms.css" rel="stylesheet">
		
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
				
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
				<a class="navbar-left" href="users.php"><img src="img/logo_mini.png" height="50px"></a>
                <a class="navbar-brand" href="users.php">&nbsp Employee Recognition Awards</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="users.php">User: <?php echo $_SESSION["username"] ?></a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="users.php">Users <span class="sr-only">(current)</span></a></li>
            <li><a href="analytics.php">Analytics</a></li>
            
          </ul>
        </div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Add User</h1>

            <form class="form-horizontal" action="addUser.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label class="control-label col-sm-2">Account Type:</label>
                    <div class="col-sm-8">

                        <div class="radio">
                            <label><input type="radio" name="type" value="regular" required>Regular User</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="type" value="admin" required>Administrator</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">First Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                    </div>
                </div>

								<div class="form-group">
                    <label class="control-label col-sm-2">Last Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                    </div>
                </div>
								
								<div class="form-group">
										<label class="control-label col-sm-2">E-mail:</label>
										<div class="col-sm-10">
												<input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
										</div>
								</div>

								<div class="form-group">
										<label class="control-label col-sm-2">State:</label>
										<div class="col-sm-10">
											<select id="state" name="state" class="form-control" required>
												<option value="Alabama">Alabama</option>
												<option value="Alaska">Alaska</option>
												<option value="Arizona">Arizona</option>
												<option value="Arkansas">Arkansas</option>
												<option value="California">California</option>
												<option value="Colorado">Colorado</option>
												<option value="Connecticut">Connecticut</option>
												<option value="Delaware">Delaware</option>
												<option value="Florida">Florida</option>
												<option value="Georgia">Georgia</option>
												<option value="Hawaii">Hawaii</option>
												<option value="Idaho">Idaho</option>
												<option value="Illinois">Illinois</option>
												<option value="Indiana">Indiana</option>
												<option value="Iowa">Iowa</option>
												<option value="Kansas">Kansas</option>
												<option value="Kentucky">Kentucky</option>
												<option value="Louisiana">Louisiana</option>
												<option value="Maine">Maine</option>
												<option value="Maryland">Maryland</option>
												<option value="Massachusetts">Massachusetts</option>
												<option value="Michigan">Michigan</option>
												<option value="Minnesota">Minnesota</option>
												<option value="Mississippi">Mississippi</option>
												<option value="Missouri">Missouri</option>
												<option value="Montana">Montana</option>
												<option value="Nebraska">Nebraska</option>
												<option value="Nevada">Nevada</option>
												<option value="New Hampshire">New Hampshire</option>
												<option value="New Jersey">New Jersey</option>
												<option value="New Mexico">New Mexico</option>
												<option value="New York">New York</option>
												<option value="North Carolina">North Carolina</option>
												<option value="North Dakota">North Dakota</option>
												<option value="Ohio">Ohio</option>
												<option value="Oklahoma">Oklahoma</option>
												<option value="Oregon">Oregon</option>
												<option value="Pennsylvania">Pennsylvania</option>
												<option value="Rhode Island">Rhode Island</option>
												<option value="South Carolina">South Carolina</option>
												<option value="South Dakota">South Dakota</option>
												<option value="Tennessee">Tennessee</option>
												<option value="Texas">Texas</option>
												<option value="Utah">Utah</option>
												<option value="Vermont">Vermont</option>
												<option value="Virginia">Virginia</option>
												<option value="Washington">Washington</option>
												<option value="West Virginia">West Virginia</option>
												<option value="Wisconsin">Wisconsin</option>
												<option value="Wyoming">Wyoming</option>
											</select>
										</div>
								</div>

								<div class="form-group">
										<label class="control-label col-sm-2">Signature (PNG):</label>
										<div class="col-sm-10">
											<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
											<input id="signature" name="signature" class="form-control" type="file" accept="image/png">
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
		
		<!-- List.js for sorting/searching the table -->
		<!-- Learn more at: http://www.listjs.com/examples/table -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>
		<script type="text/javascript">
		var options = {
			valueNames: [ 'id', 'first_name', 'last_name', 'email', 'state', 'awards', 'created', 'type' ]
		};

		var userList = new List('users', options);
		</script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
