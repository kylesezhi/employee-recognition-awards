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

    <title>Employee Recognition Awards - Award History</title>

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
                <li class="active"><a href="awardHistory.php">Award History<span class="sr-only">(current)</span></a></li>
                <li><a href="userAccount.php">Account Information</a></li>
            </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Award History</h1>

            <p>You've created and sent the following awards:</p>

            <table class="table table-hover">
                <thead>
                    <th>Award Name</th>
                    <th>Award Recipient</th>
                    <th>Award Date</th>

                </thead>
                <tbody>
                    <tr>
                        <td>Employee of the Month</td>
                        <td>Fred Johnson</td>
                        <td>09/30/2015</td>
                        <td><a href="#" class="btn btn-info" role="button">View Award</a></td>
                    </tr>
                    <tr>
                        <td>Most Sales of 2015</td>
                        <td>Sarah Fredrickson</td>
                        <td>12/31/2015</td>
                        <td><a href="#" class="btn btn-info" role="button">View Award</a></td>
                    </tr>
                    <tr>
                        <td>Best Halloween Costume</td>
                        <td>Eddie Tucker</td>
                        <td>10/31/2015</td>
                        <td><a href="#" class="btn btn-info" role="button">View Award</a></td>
                    </tr>
                    <tr>
                        <td>Employee of the Year</td>
                        <td>Bill Jones</td>
                        <td>12/31/2015</td>
                        <td><a href="#" class="btn btn-info" role="button">View Award</a></td>
                    </tr>
                </tbody>
            </table>


        </div>
    </div>
</div>


</body>
</html>