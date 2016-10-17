<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employee Recognition Awards - View Award</title>

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
            <a class="navbar-brand" href="index.php">Employee Recognition Awards</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="userAccount.php">User: JoeSmith25</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="generateAward.php">Generate Award</a></li>
                <li><a href="awardHistory.php">Award History</a></li>
                <li><a href="userAccount.php">Account Information</a></li>
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">View Award</h1>

            <?php

            $awardTitle = $_POST['awardTitle'];
            $customTitle = $_POST['customAwardTitle'];
            $recipientName = $_POST['recipientNameInput'];
            $recipientEmail = $_POST['recipientEmailInput'];
            $awardDate = $_POST['awardDateInput'];

            if ($awardTitle == "customTitle") {
                echo '<p>Award Title: ' . $customTitle . '</p>';
            }

            else {
                echo '<p>Award Title: ' . $awardTitle . '</p>';
            }

            echo '<p>Recipient Name: ' . $recipientName . '</p>';
            echo '<p>Recipient Email: ' . $recipientEmail . '</p>';
            echo '<p>Award Date: ' . $awardDate . '</p>';

            ?>


        </div>
    </div>
</div>
</body>
</html>
