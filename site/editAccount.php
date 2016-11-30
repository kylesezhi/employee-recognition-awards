<?php
require_once("dbconfig.php");

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

//Connect to the database
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
if($mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

if (isset($_POST['first_name']) & isset($_POST['last_name']) & isset($_POST['state'])) {
    if(!($stmt = $mysqli->prepare("UPDATE award_user SET first_name = ?, last_name = ?, state = ? WHERE id = ?;"))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!($stmt->bind_param("sssi",$_POST['first_name'],$_POST['last_name'],$_POST['state'],$_SESSION['user_id']))){
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }

    if(!$stmt->execute()){
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    }
    else {
        $stmt->close();
        header('Location: userAccount.php');
        exit();
    }

    $stmt->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employee Recognition Awards - Edit User Information</title>

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
                <li><a href="generateAward.php">Generate Award</a></li>
                <li><a href="awardHistory.php">Award History</a></li>
                <li><a href="userAccount.php">Account Information</a></li>
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Edit User Information</h1>

            <?php
            if(!($stmt = $mysqli->prepare("SELECT AU.first_name, AU.last_name, AU.state FROM award_user AU WHERE AU.id = ?;"))){
                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }
            if(!($stmt->bind_param("i",$_SESSION["user_id"]))){
                echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
            }
            if(!$stmt->execute()){
                echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            if(!$stmt->bind_result($first_name, $last_name, $state)){
                echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while($stmt->fetch()){
            ?>

            <form class="form-horizontal" action="editAccount.php" method="post">

                <div class="form-group">
                    <label class="control-label col-sm-2">First Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name ?>" placeholder="First Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Last Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name ?>" placeholder="Last Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">State:</label>
                    <div class="col-sm-10">
                        <select id="state" name="state" class="form-control" required>
                            <option value="Alabama"<?php if($state === "Alabama") echo " selected"; ?>>Alabama</option>
                            <option value="Alaska"<?php if($state === "Alaska") echo " selected"; ?>>Alaska</option>
                            <option value="Arizona"<?php if($state === "Arizona") echo " selected"; ?>>Arizona</option>
                            <option value="Arkansas"<?php if($state === "Arkansas") echo " selected"; ?>>Arkansas</option>
                            <option value="California"<?php if($state === "California") echo " selected"; ?>>California</option>
                            <option value="Colorado"<?php if($state === "Colorado") echo " selected"; ?>>Colorado</option>
                            <option value="Connecticut"<?php if($state === "Connecticut") echo " selected"; ?>>Connecticut</option>
                            <option value="Delaware"<?php if($state === "Delaware") echo " selected"; ?>>Delaware</option>
                            <option value="Florida"<?php if($state === "Florida") echo " selected"; ?>>Florida</option>
                            <option value="Georgia"<?php if($state === "Georgia") echo " selected"; ?>>Georgia</option>
                            <option value="Hawaii"<?php if($state === "Hawaii") echo " selected"; ?>>Hawaii</option>
                            <option value="Idaho"<?php if($state === "Idaho") echo " selected"; ?>>Idaho</option>
                            <option value="Illinois"<?php if($state === "Illinois") echo " selected"; ?>>Illinois</option>
                            <option value="Indiana"<?php if($state === "Indiana") echo " selected"; ?>>Indiana</option>
                            <option value="Iowa"<?php if($state === "Iowa") echo " selected"; ?>>Iowa</option>
                            <option value="Kansas"<?php if($state === "Kansas") echo " selected"; ?>>Kansas</option>
                            <option value="Kentucky"<?php if($state === "Kentucky") echo " selected"; ?>>Kentucky</option>
                            <option value="Louisiana"<?php if($state === "Louisiana") echo " selected"; ?>>Louisiana</option>
                            <option value="Maine"<?php if($state === "Maine") echo " selected"; ?>>Maine</option>
                            <option value="Maryland"<?php if($state === "Maryland") echo " selected"; ?>>Maryland</option>
                            <option value="Massachusetts"<?php if($state === "Massachusetts") echo " selected"; ?>>Massachusetts</option>
                            <option value="Michigan"<?php if($state === "Michigan") echo " selected"; ?>>Michigan</option>
                            <option value="Minnesota"<?php if($state === "Minnesota") echo " selected"; ?>>Minnesota</option>
                            <option value="Mississippi"<?php if($state === "Mississippi") echo " selected"; ?>>Mississippi</option>
                            <option value="Missouri"<?php if($state === "Missouri") echo " selected"; ?>>Missouri</option>
                            <option value="Montana"<?php if($state === "Montana") echo " selected"; ?>>Montana</option>
                            <option value="Nebraska"<?php if($state === "Nebraska") echo " selected"; ?>>Nebraska</option>
                            <option value="Nevada"<?php if($state === "Nevada") echo " selected"; ?>>Nevada</option>
                            <option value="New Hampshire"<?php if($state === "New Hampshire") echo " selected"; ?>>New Hampshire</option>
                            <option value="New Jersey"<?php if($state === "New Jersey") echo " selected"; ?>>New Jersey</option>
                            <option value="New Mexico"<?php if($state === "New Mexico") echo " selected"; ?>>New Mexico</option>
                            <option value="New York"<?php if($state === "New York") echo " selected"; ?>>New York</option>
                            <option value="North Carolina"<?php if($state === "North Carolina") echo " selected"; ?>>North Carolina</option>
                            <option value="North Dakota"<?php if($state === "North Dakota") echo " selected"; ?>>North Dakota</option>
                            <option value="Ohio"<?php if($state === "Ohio") echo " selected"; ?>>Ohio</option>
                            <option value="Oklahoma"<?php if($state === "Oklahoma") echo " selected"; ?>>Oklahoma</option>
                            <option value="Oregon"<?php if($state === "Oregon") echo " selected"; ?>>Oregon</option>
                            <option value="Pennsylvania"<?php if($state === "Pennsylvania") echo " selected"; ?>>Pennsylvania</option>
                            <option value="Rhode Island"<?php if($state === "Rhode Island") echo " selected"; ?>>Rhode Island</option>
                            <option value="South Carolina"<?php if($state === "South Carolina") echo " selected"; ?>>South Carolina</option>
                            <option value="South Dakota"<?php if($state === "South Dakota") echo " selected"; ?>>South Dakota</option>
                            <option value="Tennessee"<?php if($state === "Tennessee") echo " selected"; ?>>Tennessee</option>
                            <option value="Texas"<?php if($state === "Texas") echo " selected"; ?>>Texas</option>
                            <option value="Utah"<?php if($state === "Utah") echo " selected"; ?>>Utah</option>
                            <option value="Vermont"<?php if($state === "Vermont") echo " selected"; ?>>Vermont</option>
                            <option value="Virginia"<?php if($state === "Virginia") echo " selected"; ?>>Virginia</option>
                            <option value="Washington"<?php if($state === "Washington") echo " selected"; ?>>Washington</option>
                            <option value="West Virginia"<?php if($state === "West Virginia") echo " selected"; ?>>West Virginia</option>
                            <option value="Wisconsin"<?php if($state === "Wisconsin") echo " selected"; ?>>Wisconsin</option>
                            <option value="Wyoming"<?php if($state === "Wyoming") echo " selected"; ?>>Wyoming</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-lg btn-primary ">Submit</button>
                    </div>
                </div>


            </form>
            <?php
            }
            $stmt->close();
            ?>

        </div>
    </div>
</div>
</body>
</html>
