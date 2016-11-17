<?php
require_once("dbconfig.php");

//Turn on error reporting
ini_set('display_errors', 'On');

//Access current session
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employee Recognition Awards - Signature Upload</title>

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
                <li><a href="#">User: <?php echo $_SESSION["username"] ?></a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Signature Upload</h1>
			
			<?php
			// File upload and error checking code from chapter 19 of "PHP and MySQL Web Development"
			// by Luke Welling and Laura Thomson
			if ($_FILES['signature']['error'] > 0) {
				echo 'Error: ';
				switch ($_FILES['signature']['error']) {
					case 1: echo 'File exceeded upload_max_filesize';
								break;
					case 2: echo 'File exceeded max_file_size';
								break;
					case 3: echo 'File only partially uploaded';
								break;
					case 4: echo 'No file uploaded';
								break;
					case 6: echo 'Cannot upload file: No temp directory specified';
								break;
					case 7: echo 'Upload failed: Cannot write to disk';
								break;
				}
				exit;
			}

			//Check if file has correct MIME type
			if ($_FILES['signature']['type'] != 'image/png') {
				echo 'Error: Incorrect file type. Must be a .png file.';
				exit;
			}

			if (is_uploaded_file ($_FILES['signature']['tmp_name'])) {
				
				//Code for adding uploaded file to SQL database adapted from http://www.sevenkb.com/php/how-to-insert-upload-image-into-mysql-database-using-php-and-how-to-display-an-image-in-php-from-mysql-database/
				
				//Get the signature image's binary data
				$signature = fopen($_FILES['signature']['tmp_name'], 'rb');
				
				//Connect to the database
				$dbinfo = "mysql:host=" . DB_HOST . ";dbname=" . DB_DB;
				$dbh = new PDO($dbinfo, DB_USER, DB_PASSWORD);
				
				//Set Error Mode
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				 
				//Prepare Update statement
				$stmt = $dbh->prepare("UPDATE award_user SET sig = ? WHERE id = ?");
				 
				//Bind parameters
				$stmt->bindParam(1, $signature, PDO::PARAM_LOB);
				$stmt->bindParam(2, $_SESSION['user_id']);
				 
				//Execute Update statement
				if ($stmt->execute()) {
					echo "<div class=\"alert alert-success\" role=\"alert\"><strong>Success!</strong> Signature file uploaded.</div>";
					echo "<br><br>";
					echo '<a href="userAccount.php" class="btn btn-md btn-primary" role="button">Back</a>';
				}
			}

			else {
				echo "File not uploaded";
			}

			?>

        </div>
    </div>
</div>
</body>
</html>
