<?php 

require_once("../dbconfig.php");

//Turn on error reporting
ini_set('display_errors', 'On');

//Connects to the database
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$result = mysqli_query($mysqli, "SELECT AU.id, AU.first_name, AU.last_name, AU.email, AU.state, AU.created, ACT.title, COUNT(A.class_id) AS 'totalAwards' FROM award_user AU LEFT JOIN award A ON A.user_id = AU.id INNER JOIN act_type ACT ON ACT.id = AU.act_id GROUP BY AU.email ORDER BY AU.id;");
$output = ["cols" => [
	["id" => "", "label" => "User ID", "pattern" => "", "type" => "string"],
	["id" => "", "label" => "First name", "pattern" => "", "type" => "string"],
	["id" => "", "label" => "Last name", "pattern" => "", "type" => "string"],
	["id" => "", "label" => "Email", "pattern" => "", "type" => "string"],
	["id" => "", "label" => "State", "pattern" => "", "type" => "string"],
	["id" => "", "label" => "Created", "pattern" => "", "type" => "string"],
	["id" => "", "label" => "Type", "pattern" => "", "type" => "string"],
	["id" => "", "label" => "Awards", "pattern" => "", "type" => "string"],
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
