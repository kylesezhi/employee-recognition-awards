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

    <title>Employee Recognition Awards</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

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
            <li class="active"><a href="#">Users <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Data</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
          <!-- PAGE CONTENT -->
          <h1 class="page-header">Users</h1>
          <div class="panel-heading">
            <div class="pull-right"><button type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add user</button></div>
        </div>
          <h2 class="sub-header">Admin users</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Email</th>
                  <th>State</th>
                  <th>Awards sent</th>
                  <th>User created</th>
                  <th>Signature</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(!($stmt = $mysqli->prepare("SELECT AU.first_name, AU.last_name, AU.email, AU.state, AU.id, AU.created, AU.sig from award_user AU INNER JOIN act_type ACT ON ACT.id = AU.act_id WHERE ACT.title = 'admin'"))){
                  echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
                }
                if(!$stmt->execute()){
                  echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt->bind_result($first_name, $last_name, $email, $state, $id, $created, $sig)){
                  echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                while($stmt->fetch()){
                  echo "<tr>";
                  echo "<td class=\"id\">" . $id . "</td>";
                  echo "<td class=\"first_name\">" . $first_name . "</td>";
                  echo "<td class=\"last_name\">" . $last_name . "</td>";
                  echo "<td class=\"email\">" . $email . "</td>";
                  echo "<td class=\"state\">" . $state . "</td>";
                  echo "<td class=\"awards_sent\">" . 'TODO' . "</td>";
                  echo "<td class=\"created\">" . $created . "</td>";
                  echo "<td class=\"sig\">" . $sig . "</td>";
                  echo "<td class=\"edit\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\"></span> Edit</button></td>";
                  echo "<td class=\"delete\"><button type=\"button\" class=\"btn btn-danger btn-sm\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span> Delete</button></td>";
                  echo "</tr>";
                }
                $stmt->close();
                ?>
              </tbody>
            </table>
						<nav aria-label="Page navigation">
						  <ul class="pagination">
						    <li class="page-item">
						      <a class="page-link" href="#" aria-label="Previous">
						        <span aria-hidden="true">&laquo;</span>
						        <span class="sr-only">Previous</span>
						      </a>
						    </li>
						    <li class="page-item"><a class="page-link" href="#">1</a></li>
						    <li class="page-item"><a class="page-link" href="#">2</a></li>
						    <li class="page-item"><a class="page-link" href="#">3</a></li>
						    <li class="page-item"><a class="page-link" href="#">4</a></li>
						    <li class="page-item"><a class="page-link" href="#">5</a></li>
						    <li class="page-item">
						      <a class="page-link" href="#" aria-label="Next">
						        <span aria-hidden="true">&raquo;</span>
						        <span class="sr-only">Next</span>
						      </a>
						    </li>
						  </ul>
						</nav>
          </div>

          <h2 class="sub-header">Regular users</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Email</th>
                  <th>State</th>
                  <th>Awards sent</th>
                  <th>User created</th>
                  <th>Signature</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(!($stmt2 = $mysqli->prepare("SELECT AU.first_name, AU.last_name, AU.email, AU.state, AU.id, AU.created, AU.sig from award_user AU INNER JOIN act_type ACT ON ACT.id = AU.act_id WHERE ACT.title = 'regular'"))){
                  echo "Prepare failed: " . $stmt2->errno . " " . $stmt2->error;
                }
                if(!$stmt2->execute()){
                  echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                if(!$stmt2->bind_result($first_name, $last_name, $email, $state, $id, $created, $sig)){
                  echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
                }
                while($stmt2->fetch()){
                  echo "<tr>";
                  echo "<td class=\"id\">" . $id . "</td>";
                  echo "<td class=\"first_name\">" . $first_name . "</td>";
                  echo "<td class=\"last_name\">" . $last_name . "</td>";
                  echo "<td class=\"email\">" . $email . "</td>";
                  echo "<td class=\"state\">" . $state . "</td>";
                  echo "<td class=\"awards_sent\">" . 'TODO' . "</td>";
                  echo "<td class=\"created\">" . $created . "</td>";
                  echo "<td class=\"sig\">" . $sig . "</td>";
                  echo "<td class=\"edit\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\"></span> Edit</button></td>";
                  echo "<td class=\"delete\"><button type=\"button\" class=\"btn btn-danger btn-sm\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span> Delete</button></td>";
                  echo "</tr>";
                }
                $stmt2->close();
                ?>
              </tbody>
            </table>
          </div>
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
