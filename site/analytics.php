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
	
require_once("analytics/menu.php");
	
if(!isset($_GET['first']) && !isset($_GET['second'])){
	$_GET['first'] = 'Awards';
	$_GET['second'] = 'Region';
}
if(!isset($_GET['second'])){
	$_GET['second'] = $menuItems[$_GET['first']][0];
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

    <title>Employee Recognition Awards - Analytics</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <?php 
		// imports file in analytics directory with the name "$first X $second .php"
		require_once('analytics/'. strtolower($_GET['first']) . 'X' . strtolower($_GET['second']) . '.php');
		?>
		
		<script type="text/javascript">
			var filename = '<?php echo $_GET['first'] ?>' + 'X' + '<?php echo $_GET['second'] ?>' + '.csv';
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
            <li class="active"><a href="#">Analytics</a></li>
            
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
          <!-- PAGE CONTENT -->
					<?php makeMenu($_GET['first'], $_GET['second'], $menuItems); ?>
					
					<!--Div that will hold the dashboard-->
			    <div id="dashboard_div" style="width: 100%;">
			      <!--Divs that will hold each control and chart-->
			      <div id="chart_div"></div>
						<!-- <nav class="navbar navbar-default">
						  <div class="container-fluid">
						    <div class="navbar-header">
						      <ul class="nav navbar-nav">
						      	<li><div id="filter_div1"></div></li>
						      </ul>
						    </div>
						  </div>
						</nav> -->
						
						<div class="row">
							<div class="col-md-12">
								<span class="pull-right">
								<button onclick="downloadCSV(csv, filename)" type="button" class="btn btn-sm btn-primary">
<span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download CSV
</button></span>
						</div>
						</div>
						<div class="row">&nbsp;</div>

						<div class="well">
							<div class="row">
					      <div class="col-md-3" id="filter_div1"></div>
					      <div class="col-md-3" id="filter_div2"></div>
					      <div class="col-md-3" id="filter_div3"></div>
					      <div class="col-md-3" id="filter_div4"></div>
							</div>
						</div>
				      <div id="table_div"></div>
			    </div>
					
          <!-- <div id="chart_div" style="height: 400px;"></div> -->
          
          <!-- <div id="table_div" style="height: 400px;"></div> -->

        </div>
        <!-- END PAGE CONTENT -->
        
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
