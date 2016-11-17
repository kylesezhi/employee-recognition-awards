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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employee Recognition Awards - Upload New Signature</title>

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
            <h1 class="page-header">Upload New Signature</h1>
			<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Any previous signature image for this user will be permanently lost.</div>
			<p>Select signature file to upload (.png file):</p>
						
			<form class="form" action="uploadSig.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
                    <div class="col-sm-10">
						<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
						<input type="file" name="signature" id="signature" accept="image/png">
                    </div>
                </div>
				
				<br><br>
				
				<div class="form-group">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-lg btn-primary ">Upload Signature</button>
                    </div>
                </div>
				
			</form>
        </div>
    </div>
</div>
</body>
</html>
