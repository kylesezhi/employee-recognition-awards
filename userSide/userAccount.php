<?php
//Access current session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Recognition Awards - Account Info</title>

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
            <a class="navbar-brand" href="login.php">Employee Recognition Awards</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="userAccount.php">User: <?php echo $_SESSION["username"] ?></a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="generateAward.php">Generate Award </a></li>
                <li><a href="awardHistory.php">Award History</a></li>
                <li class="active"><a href="userAccount.php">Account Information<span class="sr-only">(current)</span></a></li>
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Account Information</h1>

            <div class="panel-group">

                <div class="panel panel-default">
                    <div class="panel-heading">Username: </div>
                    <div class="panel-body"><?php echo $_SESSION["username"] ?></div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Name: </div>
                    <div class="panel-body">Joe Smith</div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">State: </div>
                    <div class="panel-body">CA</div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Signature Image: </div>
                    <div class="panel-body"><img src="JoeSmith.jpg"></div>
                </div>
            </div>

            <a href="editUserAccount.php" class="btn btn-info" role="button">Edit User Information</a>
            <a href="changePassword.php" class="btn btn-info" role="button">Change Password</a>
            <a href="newSignature.php" class="btn btn-info" role="button">Upload New Signature</a>

        </div>
    </div>
</div>






</body>
</html>