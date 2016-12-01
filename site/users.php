<?php 
require_once("dbconfig.php");

//Turn on error reporting
ini_set('display_errors', 'On');

//Access current session
session_start();

//Enforce the correct user type
if(!isset($_SESSION['account_type'])) {
    header('Location: index.php');
    exit();
}
else if($_SESSION['account_type'] === "regular") {
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
		<script type="text/javascript" src="analytics/DataTableToCSV.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript">
    google.charts.load('current', { packages: ['controls'] });
    google.charts.setOnLoadCallback(drawDashboard);

		var csv = "";
		var filename = "users.csv";
    function drawDashboard() {
        // Prepare the data
        var jsonData = $.ajax({
            url: "analytics/getUsers.php",
            dataType: "json",
            async: false
            }).responseText;
        
				var jsonDataCSV = $.ajax({
						url: "analytics/getUsersCSV.php",
						dataType: "json",
						async: false
						}).responseText;
				
        var data = new google.visualization.DataTable(jsonData);
        var dataCSV = new google.visualization.DataTable(jsonDataCSV);
				csv = dataTableToCSV(dataCSV);

        // create a list of columns for the dashboard
        var columns = [{
            // this column aggregates all of the data into one column
            // for use with the string filter
            type: 'string',
            calc: function (dt, row) {
                for (var i = 0, vals = [], cols = dt.getNumberOfColumns(); i < cols; i++) {
                    vals.push(dt.getFormattedValue(row, i));
                }
                return vals.join('\n');
            }
        }];
        
        for (var i = 0, cols = data.getNumberOfColumns(); i < cols; i++) {
            columns.push(i);
        }
        
        // Define a string filter for all columns
        var filter = new google.visualization.ControlWrapper({
            controlType: 'StringFilter',
            containerId: 'filter_div',
            options: {
                filterColumnIndex: 0,
                matchType: 'any',
                caseSensitive: false,
                ui: {
                    label: 'Search:'
                }
            },
            view: {
                columns: columns
            }
        });
        
        // Options for table
        var options = {
          width: '100%', 
          page: 'enable',
          pageSize: 14,
          allowHtml: true,
        };
        
        // Define table
        var table = new google.visualization.ChartWrapper({
            chartType: 'Table',
            containerId: 'container_div',
            options,
            view: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            }
        });
        
        var dashboard = new google.visualization.Dashboard(document.getElementById('dashboard'));
        dashboard.bind([filter], [table]);
        dashboard.draw(data);
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
		            <a class="navbar-left" href="#"><img src="img/logo_mini.png" height="50px"></a>
					<a class="navbar-brand" href="#">&nbsp Employee Recognition Awards</a>
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
            
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
          <!-- PAGE CONTENT -->
          <div class="panel-heading">
            <div class="pull-right"><a href="addUser.php" type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add user</a></div>
        </div>
          <h2 class="sub-header">Users</h2>
					
					<!-- <input class="search form-control" placeholder="Search" /> -->
					<div class="row">
						<div class="col-md-6" id="filter_div"></div>
						<div class="col-md-6">
							<span class="pull-right"><button onclick="downloadCSV(csv, filename)" type="button" class="btn btn-sm btn-primary">
<span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download CSV
</button></span>
						</div>
					</div>
					<div class="row">&nbsp;</div>
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
