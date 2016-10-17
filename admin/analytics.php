<?php 
require_once("dbconfig.php");

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
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('upcoming', {'packages': ['geochart']});
      google.charts.setOnLoadCallback(drawUSMap);
      
      function drawUSMap() {

        var data = google.visualization.arrayToDataTable([
          ['State','Awards'],
          <?php
          if(!($stmt = $mysqli->prepare("SELECT AU.state, COUNT(CL.id) AS 'AwardCount' FROM award_user AU INNER JOIN award A ON A.user_id = AU.id INNER JOIN class CL ON CL.id = A.class_id GROUP BY AU.state ORDER BY AU.state;"))){
            echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
          }
          if(!$stmt->execute()){
            echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          if(!$stmt->bind_result($state, $awards)){
            echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          while($stmt->fetch()){
            if($state != 'District of Columbia') {
              echo "['" . $state . "', " . $awards . "],";
            }
          }
          $stmt->close();
          ?>
          
          // ['Alabama', 0],
          // ['Alaska', 0],
          // ['Arizona', 50],
          // ['Arkansas', 0],
          // ['California', 0],
          // ['Colorado', 0],
          // ['Connecticut', 50],
          // ['Delaware', 0],
          // ['Florida', 0],
          // ['Georgia', 60],
          // ['Hawaii', 0],
          // ['Idaho', 0],
          // ['Illinois', 30],
          // ['Indiana', 0],
          // ['Iowa', 0],
          // ['Kansas', 70],
          // ['Kentucky', 0],
          // ['Louisiana', 30],
          // ['Maine', 0],
          // ['Maryland', 0],
          // ['Massachusetts', 20],
          // ['Michigan', 0],
          // ['Minnesota', 0],
          // ['Mississippi', 0],
          // ['Missouri', 0],
          // ['Montana', 0],
          // ['Nebraska', 0],
          // ['Nevada', 0],
          // ['New Hampshire', 0],
          // ['New Jersey', 0],
          // ['New Mexico', 0],
          // ['New York', 0],
          // ['North Carolina', 0],
          // ['North Dakota', 0],
          // ['Ohio', 0],
          // ['Oklahoma', 0],
          // ['Oregon', 0],
          // ['Pennsylvania', 0],
          // ['Rhode Island', 0],
          // ['South Carolina', 0],
          // ['South Dakota', 0],
          // ['Tennessee', 0],
          // ['Texas', 0],
          // ['Utah', 0],
          // ['Vermont', 0],
          // ['Virginia', 0],
          // ['Washington', 0],
          // ['West Virginia', 0],
          // ['Wisconsin', 0],
          // ['Wyoming', 0]
        ]);

        var options = {
          region: "US", 
          resolution: "provinces",
          colorAxis: {colors: ['#F48023', '#F25621', '#93191B']},
        };

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
        chart.draw(data, options);
      }
      
      var chart = new google.visualization.GeoChart(container);
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
            <li class="active"><a href="#">Analytics</a></li>
            <li><a href="data.php">Data</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
          <!-- PAGE CONTENT -->
          <div class="">
            <div class="btn-group">
              <button class="btn btn-primary btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Awards <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="#">Users</a></li>
              </ul>
            </div>
            BY
            <div class="btn-group">
              <button class="btn btn-primary btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Region <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="#">User</a></li>
                <li><a href="#">Date</a></li>
                <li><a href="#">Time</a></li>
              </ul>
            </div>
          </div>
          
          <div id="regions_div" style="height: 400px;"></div>
          
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Username</th>
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
                <tr>
                  <td>1,001</td>
                  <td>Lorem</td>
                  <td>ipsum</td>
                  <td>dolor</td>
                  <td>sit</td>
                  <td>1,002</td>
                  <td>amet</td>
                  <td>consectetur</td>
                  <td>adipiscing</td>
                  <td><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button></td>
                  <td><button type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button></td>
                </tr>
                <tr>
                  <td>1,001</td>
                  <td>Lorem</td>
                  <td>ipsum</td>
                  <td>dolor</td>
                  <td>sit</td>
                  <td>1,002</td>
                  <td>amet</td>
                  <td>consectetur</td>
                  <td>adipiscing</td>
                  <td><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</button></td>
                  <td><button type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button></td>
                </tr>
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
