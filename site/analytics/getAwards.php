<?php 

require_once("../dbconfig.php");

//Turn on error reporting
ini_set('display_errors', 'On');

//Connects to the database
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$result = mysqli_query($mysqli, "SELECT A.id, CONCAT(AU.first_name, ' ', AU.last_name) as sender, CONCAT(A.first_name, ' ', A.last_name) as recipient, C.title as award, award_date, state FROM award A INNER JOIN award_user AU ON A.user_id = AU.id INNER JOIN class C ON A.class_id = C.id;");
$output = ["cols" => [
	["id" => "", "label" => "ID", "pattern" => "", "type" => "number"],
	["id" => "", "label" => "Sender", "pattern" => "", "type" => "string"],
	["id" => "", "label" => "Receiver", "pattern" => "", "type" => "string"],
	["id" => "", "label" => "Award", "pattern" => "", "type" => "string"],
	["id" => "", "label" => "Date", "pattern" => "", "type" => "date"],
	["id" => "", "label" => "State", "pattern" => "", "type" => "string"],
]];
$rows = array();
$id = -1;
while($r = mysqli_fetch_assoc($result)) {
	$item = array();
	 foreach ($r as $key => $value) {
		 if ($key === 'id') $id = $value;
			$item[] = ["v" => $value, "f" => null];
	 }
	 $rows[] = ["c" => $item ];
 }
$output["rows"] = $rows;
print json_encode($output);
$result->close();

?>
