<?php 
require_once("dbconfig.php");

//Turn on error reporting
ini_set('display_errors', 'On');

//Access current session
session_start();

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
		
    <!-- Custom styles for List.js -->
    <link href="list.css" rel="stylesheet">
		
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
          <div class="table-responsive" id="users">
						<input class="search form-control" placeholder="Search" />
            <table class="table table-striped">
              <thead>
                <tr>
                  <th><button class="sort asc" data-sort="id">ID</button></th>
                  <th><button class="sort" data-sort="first_name">First name</th>
                  <th><button class="sort" data-sort="last_name">Last name</th>
                  <th><button class="sort" data-sort="email">Email</th>
                  <th><button class="sort" data-sort="state">State</th>
                  <th><button class="sort" data-sort="awards">Awards</th>
                  <th><button class="sort" data-sort="created">Created</th>
                  <th><button class="sort" data-sort="type">Type</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="list">
                <?php
                if(!($stmt = $mysqli->prepare("SELECT AU.first_name, AU.last_name, AU.email, AU.state, AU.id, AU.created, ACT.title, COUNT(A.class_id) AS 'totalAwards' FROM award_user AU LEFT JOIN award A ON A.user_id = AU.id INNER JOIN act_type ACT ON ACT.id = AU.act_id GROUP BY AU.email ORDER BY AU.id;"))){
                  echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                  echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($first_name, $last_name, $email, $state, $id, $created, $type, $awards)){
                  echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                while($stmt->fetch()){
                  echo "<tr>";
                  echo "<td class=\"id\">" . $id . "</td>";
                  echo "<td class=\"first_name\">" . $first_name . "</td>";
                  echo "<td class=\"last_name\">" . $last_name . "</td>";
                  echo "<td class=\"email\">" . $email . "</td>";
                  echo "<td class=\"state\">" . $state . "</td>";
                  echo "<td class=\"awards\">" . $awards . "</td>";
                  echo "<td class=\"created\">" . $created . "</td>";
                  echo "<td class=\"type\">"; 
									if($type == "regular") echo "User";
									else echo "Admin";
									echo "</td>";
                  echo "<td class=\"edit\"><form method=\"post\" action=\"editUser.php\"><input type=\"hidden\" name=\"id\" value=\"" . $id . "\"><button href=\"#\" class=\"btn btn-primary btn-sm\"><span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\"></span> Edit</button></form></td>";
                  echo "<td class=\"delete\"><button type=\"button\" class=\"btn btn-danger btn-sm\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span> Delete</button></td>";
                  echo "</tr>";
                }
                $stmt->close();
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- END PAGE CONTENT -->
        
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
