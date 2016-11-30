<?php
//Turn on error reporting
ini_set('display_errors', 'On');

//Access current session
session_start();

//Redirect if user not logged in, or if logged in as other type of user
if(!isset($_SESSION['account_type'])) {
    header('Location: index.php');
    exit();
}
else if($_SESSION['account_type'] === "admin") {
    header('Location: users.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employee Recognition Awards - Create Award</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="dashboard.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="awardform.css" rel="stylesheet">

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
			<a class="navbar-left" href="generateAward.php"><img src="img/logo_mini.png" height="50px"></a>
            <a class="navbar-brand" href="generateAward.php">&nbsp Employee Recognition Awards</a>
			
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
                <li class="active"><a href="generateAward.php">Generate Award <span class="sr-only">(current)</span></a></li>
                <li><a href="awardHistory.php">Award History</a></li>
                <li><a href="userAccount.php">Account Information</a></li>
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Generate Award</h1>

            <form class="form-horizontal" action="award.php" method="post">

                <div class="form-group">
                    <label class="control-label col-sm-2">Award Title:</label>
                    <div class="col-sm-8">

                        <div class="radio">
                            <label><input type="radio" name="awardTitle" value="Employee of the Year" checked>Employee of the Year</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="awardTitle" value="Employee of the Month">Employee of the Month</label>
                        </div>
                        <div class="radio inline-radio">
                            <label><input type="radio" name="awardTitle" value="customTitle"></label>
                            Custom Title: <input type="text" class="form-control" name="customAwardTitle" placeholder="Custom Title">
                        </div>
                    </div>
                </div>

				<div class="form-group">
                    <label class="control-label col-sm-2" id="proclamation">Proclamation:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="proclamation" placeholder="Proclamation" name="proclamation" value="for outstanding performance, service, and dedication." maxlength="60" required>
                    </div>
                </div>
				
                <div class="form-group">
                    <label class="control-label col-sm-2" id="recipientFirstNameInput">Recipient First Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="recipientFirstNameInput" name="recipientFirstNameInput" placeholder="Recipient First Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" id="recipientLastNameInput">Recipient Last Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="recipientLastNameInput" name="recipientLastNameInput" placeholder="Recipient Last Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="recipientEmailInput">Recipient's Email Address:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="recipientEmailInput" name="recipientEmailInput" placeholder="Recipient Email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="awardDateInput">Award Date:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="awardDateInput" name="awardDateInput"placeholder="Award Date" required>
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
</body>
</html>
