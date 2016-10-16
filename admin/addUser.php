<?php 
require("dbconfig.php");

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
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
    <link href="forms.css" rel="stylesheet">
		
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
          <a class="navbar-brand" href="#">Employee Recognition Awards</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Sign out</a></li>
          </ul>
          <p class="navbar-text navbar-right">Signed in as <a href="#" class="navbar-link">consectetur</a></p>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="index.php">Users <span class="sr-only">(current)</span></a></li>
            <li><a href="analytics.php">Analytics</a></li>
            <li><a href="data.php">Data</a></li>
          </ul>
        </div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Add User</h1>

            <form class="form-horizontal" action="award.php" method="post">

                <div class="form-group">
                    <label class="control-label col-sm-2">Account Type:</label>
                    <div class="col-sm-8">

                        <div class="radio">
                            <label><input type="radio" name="type" value="user" required>Regular User</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="type" value="admin" required>Administrator</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">First Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="first_name" placeholder="First Name" required>
                    </div>
                </div>

								<div class="form-group">
                    <label class="control-label col-sm-2">Last Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="last_name" placeholder="Last Name" required>
                    </div>
                </div>
								
								<div class="form-group">
										<label class="control-label col-sm-2">E-mail:</label>
										<div class="col-sm-10">
												<input type="email" class="form-control" id="email" placeholder="E-mail" required>
										</div>
								</div>

								<div class="form-group">
										<label class="control-label col-sm-2">Password:</label>
										<div class="col-sm-10">
												<input type="password" class="form-control" id="password" placeholder="Password" required>
										</div>
								</div>

								<div class="form-group">
										<label class="control-label col-sm-2">State:</label>
										<div class="col-sm-10">
											<select id="state" class="form-control" required>
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
											<input id="signature" class="form-control" type="file">
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