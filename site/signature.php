<?php
//include database connection
require_once("dbconfig.php");

//Turn on error reporting
ini_set('display_errors', 'On');

//Connects to the database
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

//select the image
if(!($stmt = $mysqli->prepare("SELECT sig FROM award_user WHERE id = ?;"))){
  echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_GET['id']))){
  echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
  echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($image)){
  echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
$stmt->fetch();
if($image) {
  header("Content-type: image/png");
  echo $image;
} else {
  header("Content-type: image/png");
  echo file_get_contents("img_not_available.png");
}

?>
