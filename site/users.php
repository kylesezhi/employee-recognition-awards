<?php 
require_once("dbconfig.php");

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

    <title>Employee Recognition Awards - Users</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

		<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.charts.load('current', {'packages':['table']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawTable);
      
    function drawTable() {
      var jsonData = $.ajax({
          url: "analytics/getUsers.php",
          dataType: "json",
          async: false
          }).responseText;
          
      var options = {
        width: '100%', 
        page: 'enable',
        pageSize: 15,
        allowHtml: true,
      };
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);

      // Instantiate and draw our chart, passing in some options.
      var table = new google.visualization.Table(document.getElementById('container_div'));

      table.draw(data, options);
    }

    </script>

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
            <li class="active"><a href="#">Users <span class="sr-only">(current)</span></a></li>
            <li><a href="analytics.php">Analytics</a></li>
            <li><a href="data.php">Data</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
          <!-- PAGE CONTENT -->
          <div class="panel-heading">
            <div class="pull-right"><a href="addUser.php" type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add user</a></div>
        </div>
          <h2 class="sub-header">Users</h2>
          <div id="container_div"></div>
					<!-- END PAGE CONTENT -->
        </div>
        
        
      </div>
    </div>
		

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
