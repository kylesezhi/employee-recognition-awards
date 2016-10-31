<?php 

require_once("../dbconfig.php");

//Turn on error reporting
ini_set('display_errors', 'On');

//Connects to the database
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$result = mysqli_query($mysqli, "SELECT AU.state, COUNT(AU.email) AS 'UserCount' FROM award_user AU GROUP BY AU.state ORDER BY AU.state;");
$output = ["cols" => [
	["id" => "", "label" => "State", "pattern" => "", "type" => "string"],
	["id" => "", "label" => "Users", "pattern" => "", "type" => "number"],
]];
$rows = array();
while($r = mysqli_fetch_assoc($result)) {
	$item = array();
	 foreach ($r as $key => $value) {
		 if ($key === 'UserCount') {
			 $item[] = ["v" => intval($value), "f" => null];
		 } else {
			$item[] = ["v" => $value, "f" => null];
		 }
	 }
	 $rows[] = ["c" => $item ];
 }
$output["rows"] = $rows;
print json_encode($output);
$result->close();

?>
