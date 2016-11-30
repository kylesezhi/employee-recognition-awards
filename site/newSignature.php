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

if(isset($_GET['id'])) {
  $querystring = '?id=' . $_GET['id'];
  $jsvar = 'data-id="' . $_GET['id'] . '"';
  // echo '<script>var id = ' . $_GET['id'] . ';</script>';
} else {
  $querystring = '';
  $jsvar = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employee Recognition Awards - New Signature</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="dashboard.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="awardform.css" rel="stylesheet">
	<link href="signature-pad.css" rel="stylesheet">

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
            <a class="navbar-left" href="#"><img src="img/logo_mini.png" height="50px"></a>
            <a class="navbar-brand" href="#">&nbsp Employee Recognition Awards</a>
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
            <h1 class="page-header">New Signature</h1>
			
			<p>To use a new signature for this user, either upload a .png image file showing the signature or simply draw a signature in the box below.</p>
			
			<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Any previous signature image for this user will be permanently lost.</div>
			
			<!-- Upload signature file -->
			<div class="panel panel-primary">
				<div class="panel-heading">Upload Signature File</div>
				<div class="panel-body">
					<p>Select signature file to upload (.png file):</p>
								
					<form class="form" action="uploadSig.php<?php echo $querystring; ?>" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<div class="col-sm-10">
								<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
								<input type="file" name="signature" id="signature" accept="image/png" required>
							</div>
						</div>
						
						<br><br>
						
						<div class="form-group">
							<div class="col-sm-10">
								<button type="submit" class="btn btn-md btn-primary "><span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> Upload Signature</button>
							</div>
						</div>
						
					</form>
				</div>
			</div>
			
			
			<!-- Alternately, draw own signature --> 
			<!-- Code adapted from Szymon Nowak's Signature Pad project: https://github.com/szimek/signature_pad -->
			<div class="panel panel-primary">
				<div class="panel-heading">Draw Signature</div>
				<div class="panel-body">

					<div>
						<div id="signature-pad" class="m-signature-pad">
						
						<div class="m-signature-pad--body">
							<canvas></canvas>
						</div>
						
						<div class="m-signature-pad--footer">
							<div class="description">Sign above</div>
								<button type="button" class="button clear" data-action="clear">Clear</button>
								<button type="button" class="button save" data-action="save">Save</button>
							</div>
						</div>
					
						<script type="text/javascript" src="js/signature_pad.js"></script>
            <!-- <script type="text/javascript">
              alert('TEST');
              console.log('TEST');
            </script> -->
						<script type="text/javascript" <?php echo $jsvar; ?> src="js/drawSig.js"></script>
					</div>
					
					<br><br><br><br><br><br><br><br><br><br><br>
				</div>
			</div>
			
			
        </div>
    </div>
</div>
</body>
</html>
